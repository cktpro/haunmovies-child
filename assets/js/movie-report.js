function showCustomToast(type, text) {
    let backgroundStyle = '';
    let iconHtml = '';

    switch (type) {
        case 'warning':
            backgroundStyle = '#1f1f1f';
            iconHtml = '<span class="toast-icon toast-icon-warning">⚠️</span>';
            break;
        case 'success':
            backgroundStyle = 'linear-gradient(to right, rgb(52 92 8), rgb(80 205 142))';
            iconHtml = '<span class="toast-icon toast-icon-success">✓</span>';
            break;
        case 'info':
            backgroundStyle = '#1f1f1f';
            iconHtml = '<span class="toast-icon toast-icon-info">ℹ️</span>';
            break;
        case 'error':
            backgroundStyle = 'linear-gradient(to right, rgb(176 0 16), rgb(205 121 80))';
            iconHtml = '<span class="toast-icon toast-icon-error">✖</span>';
            break;
        default:
            backgroundStyle = '#1f1f1f';
            iconHtml = '<span class="toast-icon">ℹ️</span>';
    }

    const toastContent = `
                <div class="toast-content-wrapper">
                    ${iconHtml}
                    <span class="toast-text">${text}</span>
                   
                </div>
            `;

    Toastify({
        text: toastContent,
        duration: 3000,
        gravity: 'top',
        position: 'center',
        stopOnFocus: true,
        escapeMarkup: false,
        style: {
            background: backgroundStyle
        },
        className: 'toastify-timeline',
        onClick: function (e) {
            if (e && e.target && $(e.target).hasClass('toast-close-button')) {
                this.hideToast(); // This will close the toast
            }
        }
    }).showToast();
}
jQuery(document).ready(function ($) {
    var n = $('#keyword-ep');
    var timer;
    function filterEpisodes() {
        var keyword = n.val().trim();
        var resultDiv = $('#suggestions-ep');
        resultDiv.stop(true, true); // dừng animation cũ

        if (keyword.length > 0) {
            $('#loading-ep').show();
            const episodes = document.querySelectorAll('#listsv-1 li');
            let found = false;

            // tạo container tạm để append
            let temp = $('<ul></ul>');

            episodes.forEach((li) => {
                const span = li.querySelector('span');
                const episodeText = span ? span.textContent.trim() : '';

                if (episodeText.includes(keyword)) {
                    found = true;
                    temp.append($(li).clone());
                }
            });

            $('#loading-ep').hide();

            if (found) {
                resultDiv.html(temp.html()).slideDown(300); // chỉ cập nhật sau khi build xong
            } else {
                resultDiv.html('<p>Không có tập nào!</p>').slideDown(300);
            }
        } else {
            resultDiv.slideUp(200); // input trống -> ẩn
        }
    }

    // debounce
    n.on('keyup', function () {
        clearTimeout(timer);
        timer = setTimeout(filterEpisodes, 1000);
    });

    n.on('keydown', function () {
        clearTimeout(timer);
    });
    const Rating = function () {
        const $modal = $('#ratingModal');
        const $options = $modal.find('.movie-rating-rating-option');
        const $submitBtn = $('#submitRatingBtn');
        const $totalVotes = parseInt($('span.rating-votes').text(), 10);
        let selectedRating = 0;

        // Hover highlight
        $options
            .on('mouseenter', function () {
                const value = $(this).data('value');
                $options.each(function () {
                    $(this).toggleClass('hovered', $(this).data('value') <= value);
                });
            })
            .on('mouseleave', function () {
                $options.removeClass('hovered');
            });

        // Click chọn rating
        $options.on('click', function () {
            selectedRating = $(this).data('value');
            $options.removeClass('selected');
            $(this).addClass('selected');
        });
        // Gửi đánh giá
        $submitBtn.on('click', function () {
            if (!selectedRating) {
                showCustomToast('warning', 'Vui lòng chọn đánh giá trước khi gửi!');
                return;
            }
            const postId = $modal.data('post-id');
            $submitBtn.prop('disabled', true).text('Đang gửi...');
            $.ajax({
                url: halim_rate.ajaxurl,
                method: 'POST',
                data: {
                    action: 'halim_rate_post',
                    nonce: halim_rate.nonce,
                    post: postId,
                    value: selectedRating
                },
                dataType: 'text',
                success: function (res) {
                    if (res != 'Voted') {
                        // $totalRating.text(res.data.new_rating);
                        // $totalVotes.text(res.data.total_votes);
                        $('span.score').html(res);
                        $('span.rating-votes').html($totalVotes + 1);
                        showCustomToast('success', 'Cảm ơn bạn đã đánh giá!');
                    } else {
                        showCustomToast('info', 'Bạn đã đánh giá phim này rồi!');
                    }
                    $modal.removeClass('active');
                    $submitBtn.prop('disabled', false).text('Gửi đánh giá');
                },
                error: function (xhr, status, error) {
                    showCustomToast('error', 'Có lỗi xảy ra, vui lòng thử lại!');
                    $submitBtn.prop('disabled', false).text('Gửi đánh giá');
                }
            });
        });

        // Đóng modal
        $modal.find('.close-modal-rating').on('click', function () {
            $modal.removeClass('active');
        });

        // Khi click vào button mở modal
        $(document).on('click', '.halim-rating-button', function () {
            const postId = $(this).data('post-id');
            const rating = $(this).data('rating');
            const votes = $(this).data('votes');

            $modal.data('post-id', postId);
            $modal.addClass('active');
        });
    };

    Rating(); // chạy hàm
});
