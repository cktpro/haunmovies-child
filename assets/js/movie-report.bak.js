jQuery(document).ready(function ($) {
    function showToast(message, duration = 3000) {
        // Tạo div thông báo
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.position = 'fixed';
        toast.style.top = '20px'; // cách trên cùng 20px
        toast.style.left = '50%';
        toast.style.background = 'rgba(0,0,0,0.85)';
        toast.style.color = '#fff';
        toast.style.padding = '12px 20px';
        toast.style.borderRadius = '8px';
        toast.style.fontSize = '14px';
        toast.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        toast.style.zIndex = '9999';
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';

        document.body.appendChild(toast);

        // Hiển thị
        setTimeout(() => {
            toast.style.opacity = '1';
        }, 50);

        // Ẩn sau duration
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, duration);
    }
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
                alert('Vui lòng chọn đánh giá trước khi gửi!');
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
                        showToast('Cảm ơn bạn đã đánh giá!');
                    } else {
                        showToast('Bạn đã đánh giá phim này rồi!');
                    }
                    $modal.removeClass('active');
                    $submitBtn.prop('disabled', false).text('Gửi đánh giá');
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
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
