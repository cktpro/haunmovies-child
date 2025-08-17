<?php
function haunmovies_child_enqueue_styles() {
    
    // CSS của theme cha
    wp_enqueue_style('haunmovies-style', get_template_directory_uri() . '/style.css');

    // CSS của theme con (ghi đè theme cha)
    wp_enqueue_style('haunmovies-child-style', get_stylesheet_directory_uri() . '/style.css', array('haunmovies-style'));
    
}
add_action('wp_enqueue_scripts', 'haunmovies_child_enqueue_styles');
include_once get_stylesheet_directory() . '/includes/widgets/init.php';
function haunmovies_child_create_page() {
    if ( is_admin() ) {
        // Xóa page Bookmark nếu đã tồn tại
         if(!isset(get_page_by_title('Bookmark')->ID))
        {
            $new_page_id = wp_insert_post(array(
            'post_type'    => 'page',
            'post_title'   => 'Bookmark',
            'post_content' => 'Bookmark',
            'post_status'  => 'publish',
            'post_author'  => 1,
        ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-bookmark.php');
            }
        }
         if(!isset(get_page_by_title('Lịch sử xem phim')->ID))
        {
            $new_page_id = wp_insert_post(array(
            'post_type'    => 'page',
            'post_title'   => 'Lịch sử xem phim',
            'post_content' => 'History',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_name'   => 'history',
        ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-history.php');
            }
        }
    }
}
add_action( 'admin_init', 'haunmovies_child_create_page' );

