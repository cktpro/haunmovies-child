<?php
// Include file widget
include_once get_stylesheet_directory() . '/includes/widgets/child-halim-popular-tab-widget.php';
include_once get_stylesheet_directory() . '/includes/widgets/chill-halim-carousel.php';
include_once get_stylesheet_directory() . '/includes/widgets/halim-advanced-widget-child.php';


/**
 * Ghi đè widget parent và đăng ký widget child
 */
function child_override_parent_widget()
{
    // Gỡ widget parent nếu tồn tại
    if (class_exists('halim_tab_popular_Widget')) {
        unregister_widget('halim_tab_popular_Widget');
    }
    if (class_exists('HaLim_Carousel_Slider_Widget')) {
        unregister_widget('HaLim_Carousel_Slider_Widget');
    }
    // Đăng ký widget child
    register_widget('child_halim_tab_popular_Widget');
    register_widget('HaLim_Advanced_Widget_Child');
    register_widget('HaLim_Carousel_Slider_Widget_Chill');
}
add_action('widgets_init', 'child_override_parent_widget', 15);
/**
 * Active widget child vào sidebar mặc định khi active theme
 */
function child_activate_popular_widget()
{
    $sidebars = get_option('sidebars_widgets');
    $widget_id = 'child_halim_tab_popular_widget-1'; // chú ý ID widget

    // Thêm vào sidebar 'sidebar' nếu chưa có
    if (!isset($sidebars['sidebar']) || !in_array($widget_id, $sidebars['sidebar'])) {
        $sidebars['sidebar'][] = $widget_id;
        update_option('sidebars_widgets', $sidebars);
    }

    // Tạo instance widget nếu chưa tồn tại
    $widget_instances = get_option('widget_child_halim_tab_popular_widget');
    if (!$widget_instances) {
        $widget_instances = array(
            '_multiwidget' => 1,
            1 => array(
                'title' => 'TOP Movies',
                'postnum' => 6
            )
        );
        update_option('widget_child_halim_tab_popular_widget', $widget_instances);
    }
}
add_action('after_switch_theme', 'child_activate_popular_widget');
