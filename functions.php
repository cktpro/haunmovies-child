<?php
function haunmovies_child_enqueue_styles()
{

    // CSS của theme cha
    wp_enqueue_style('haunmovies-style', get_template_directory_uri() . '/style.css');

    // CSS của theme con (ghi đè theme cha)
    wp_enqueue_style('haunmovies-child-style', get_stylesheet_directory_uri() . '/style.css', array('haunmovies-style'), '1.0.8', 'all');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', array(), '6.5.0');
    wp_enqueue_style('template-2-style', get_stylesheet_directory_uri() . '/assets/css/movie-tpl2.css', array(), '1.6', 'all');
    wp_enqueue_style('movie-style', get_stylesheet_directory_uri() . '/assets/css/top-movies.css', array(), '1.0.67', 'all');

}
add_action('wp_enqueue_scripts', 'haunmovies_child_enqueue_styles');
include_once get_stylesheet_directory() . '/includes/widgets/init.php';
function haunmovies_child_create_page()
{
    if (is_admin()) {
        if (!isset(get_page_by_title('Bookmark')->ID)) {
            $new_page_id = wp_insert_post(array(
                'post_type' => 'page',
                'post_title' => 'Bookmark',
                'post_content' => 'Bookmark',
                'post_status' => 'publish',
                'post_author' => 1,
            ));
            if ($new_page_id) {
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-bookmark.php');
            }
        }
        if (!isset(get_page_by_title('Lịch sử xem phim')->ID)) {
            $new_page_id = wp_insert_post(array(
                'post_type' => 'page',
                'post_title' => 'Lịch sử xem phim',
                'post_content' => 'History',
                'post_status' => 'publish',
                'post_author' => 1,
                'post_name' => 'history',
            ));
            if ($new_page_id) {
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-history.php');
            }
        }
        if (!isset(get_page_by_title('Top 10 Phim')->ID)) {
            $new_page_id = wp_insert_post(array(
                'post_type' => 'page',
                'post_title' => 'Top 10 Phim',
                'post_content' => 'Top 10 phim hay nhất',
                'post_status' => 'publish',
                'post_author' => 1,
                'post_name' => 'bxh-movies',
            ));
            if ($new_page_id) {
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-top10-movies.php');
            }
        }
        if (!isset(get_page_by_title('Lịch chiếu phim')->ID)) {
            $new_page_id = wp_insert_post(array(
                'post_type' => 'page',
                'post_title' => 'Lịch chiếu phim',
                'post_content' => 'Showtime',
                'post_status' => 'publish',
                'post_author' => 1,
                'post_name' => 'lich-chieu',
            ));
            if ($new_page_id) {
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-showtime.php');
            }
        }
    }
}
add_action('admin_init', 'haunmovies_child_create_page');
// Xử lý đăng nhập và đăng ký người dùng thông qua AJAX
add_action('wp_ajax_nopriv_ajaxlogin_custom', 'ajax_login_function');
function ajax_login_function()
{
    $username = sanitize_user($_POST['username']);
    $password = sanitize_text_field($_POST['password']);
    $creds = array(
        'user_login' => $username,
        'user_password' => $password,
        'remember' => true,
    );
    if (strlen($username) < 5 || strlen($username) > 20) {
        echo json_encode(['loggedin' => 0, 'message' => 'Tên đăng nhập phải từ 6 đến 20 ký tự.']);
        wp_die();
    }
    if (strlen($password) < 6 || strlen($password) > 20) {
        echo json_encode(['loggedin' => 0, 'message' => 'Mật khẩu phải từ 6 đến 20 ký tự.']);
        wp_die();
    }
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        echo json_encode(['loggedin' => 0, 'message' => 'Tên đăng nhập chỉ được chứa chữ và số.']);
        wp_die();
    }
    // Mật khẩu chỉ có @,chữ và số
    if (!preg_match('/^[a-zA-Z0-9@]+$/', $password)) {
        echo json_encode(['loggedin' => 0, 'message' => 'Mật khẩu chỉ được chứa chữ, số và ký tự @.']);
        wp_die();
    }
    if (empty($username) || empty($password)) {
        echo json_encode(['loggedin' => 0, 'message' => 'Vui lòng nhập tên đăng nhập và mật khẩu']);
        wp_die();
    }
    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        echo json_encode(['loggedin' => 0, 'message' => 'Sai tài khoản hoặc mật khẩu']);
    } else {
        echo json_encode(['loggedin' => 1, 'message' => 'Đăng nhập thành công']);
    }
    wp_die();
}
add_action('wp_ajax_nopriv_ajaxregister_custom', 'ajax_register_function');
function ajax_register_function()
{
    $username = sanitize_user($_POST['username']);
    $password = sanitize_text_field($_POST['password']);
    $email = sanitize_email($_POST['email']);

    //  Kiểm tra rỗng
    if (empty($username) || empty($password) || empty($email)) {
        echo json_encode(['registered' => 0, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
        wp_die();
    }

    //  Kiểm tra username
    if (strlen($username) < 6 || strlen($username) > 20) {
        echo json_encode(['registered' => 0, 'message' => 'Tên đăng nhập phải từ 6 đến 20 ký tự.']);
        wp_die();
    }
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        echo json_encode(['registered' => 0, 'message' => 'Tên đăng nhập chỉ được chứa chữ và số.']);
        wp_die();
    }
    if (username_exists($username)) {
        echo json_encode(['registered' => 0, 'message' => 'Tên đăng nhập đã tồn tại.']);
        wp_die();
    }

    //  Kiểm tra password
    if (strlen($password) < 6 || strlen($password) > 20) {
        echo json_encode(['registered' => 0, 'message' => 'Mật khẩu phải từ 6 đến 20 ký tự.']);
        wp_die();
    }
    if (!preg_match('/^[a-zA-Z0-9@]+$/', $password)) {
        echo json_encode(['registered' => 0, 'message' => 'Mật khẩu chỉ được chứa chữ, số và ký tự @.']);
        wp_die();
    }

    //  Kiểm tra email
    if (!is_email($email)) {
        echo json_encode(['registered' => 0, 'message' => 'Email không hợp lệ.']);
        wp_die();
    }
    if (email_exists($email)) {
        echo json_encode(['registered' => 0, 'message' => 'Email đã tồn tại.']);
        wp_die();
    }

    //  Tạo user
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        echo json_encode(['registered' => 0, 'message' => 'Có lỗi xảy ra khi đăng ký.']);
    } else {
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);
        echo json_encode(['registered' => 1, 'message' => 'Đăng ký thành công!']);
    }

    wp_die();
}
// Disable  login bar
add_filter('show_admin_bar', function ($show) {
    if (!is_admin()) {
        return false;
    }
    return $show; // giữ admin bar ở backend
});
add_filter('walker_nav_menu_start_el', function ($item_output, $item, $depth, $args) {

    // Lấy slug của page/post
    $slug = basename(get_permalink($item->object_id));

    // Danh sách slug và icon tương ứng
    $icons = [
        'lich-chieu' => 'fa-solid fa-calendar-days',
        'completed' => 'fa-regular fa-circle-check',
        'bxh-movies' => 'fa-solid fa-trophy'
    ];
    $menu_path = trim($item->url, '/');

    // Lấy path trang chủ (thường rỗng)
    $home_path = trim(parse_url(home_url(), PHP_URL_PATH), '/');

    if ($menu_path === $home_path) {
        // Chèn icon FA ngay trước nội dung <a>
        $item_output = preg_replace(
            '/(<a\b[^>]*>)(.*?)(<\/a>)/i',
            '$1<i class="fa-solid fa-house"></i> $2$3',
            $item_output
        );
    }
    if (isset($icons[$slug])) {
        // Chỉ thay nội dung <a> hiển thị, không động vào title attribute
        $item_output = '<a href="' . esc_url($item->url) . '"><i class="' . esc_attr($icons[$slug]) . '"></i> ' . esc_html($item->title) . '</a>';
    }

    return $item_output;

}, 10, 4);

function mytheme_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script(
        'movie-report',
        get_stylesheet_directory_uri() . '/assets/js/movie-report.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/js/movie-report.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');