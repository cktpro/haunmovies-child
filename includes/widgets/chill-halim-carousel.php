<?php

class HaLim_Carousel_Slider_Widget_Chill extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'halim-carousel-widget-chill',
            __('HaLim Carousel Slide Chill', 'halimthemes'),
            array(
                'classname' => 'halim-carousel-widget-chill',
                'description' => __('Display posts with Carousel slider By R', 'halimthemes')
            )
        );
    }

    public function widget($args, $instance)
    {
        extract($args);
        $title = $instance['title'];
        $categories = $instance['categories'];
        $type = $instance['type'];
        $postnum = $instance['postnum'];
        $item = $instance['item'];
        $url = $instance['url'];
        $rand = $instance['rand'];
        echo $before_widget;
        ob_start();
        ?>
        <div id="<?php echo $widget_id; ?>xx" class="wrap-slider">
            <?php if ($title != ''): ?>
                <div class="section-bar clearfix">
                    <?php if ($type == 'theloai'): ?>
                        <h3 class="section-title">
                            <a href="<?php echo get_category_link($categories) ?>"
                                title="<?php echo $title ?>"><span><?php echo $title; ?></span></a>
                        </h3>
                        <div class="np-viewall">
                            <a href="<?php echo ($categories == 'all') ? $url : get_category_link($categories); ?>">
                                <span class="hl-forward"></span> <?php _e('View all', 'halimthemes') ?></a>
                        </div>
                    <?php else: ?>
                        <h3 class="section-title"><span><?php echo $title; ?></span></h3>
                    <?php endif ?>
                </div>
            <?php endif ?>
            <div id="<?php echo $widget_id; ?>" class="owl-carousel owl-theme custom-carousel">
                <?php
                if ($postnum > 10) {
                    $postnum = 9; // 
                }
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $postnum,
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-aside', 'post-format-gallery'),
                            'operator' => 'IN' //NOT IN
                        )
                    ),
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'halim_view_post_all'
                        )

                    ),
                );

                $args['cat'] = $categories;
                $wp_query = new WP_Query($args);
                if ($wp_query->have_posts()):
                    $item_counter = 0;
                    while ($wp_query->have_posts()):
                        $wp_query->the_post();
                        $class = ($item_counter % 2 == 0) ? 'clip-path-even' : 'clip-path-odd';
                        $item_counter++;
                        // Lấy dữ liệu
                        $post_id = get_the_ID();
                        $title = get_the_title();
                        $permalink = get_permalink();
                        $thumbnail = get_the_post_thumbnail_url($post_id, 'medium'); // size: medium, large, full
                        $alt = esc_attr($title);

                        // Custom field (nếu có meta 'status' hoặc 'episode')
                        $status = get_post_meta($post_id, 'status', true) ?: 'Vietsub - HD';
                        $episode = get_post_meta($post_id, 'episode', true) ?: 'Tập ?';
                        ?>
                        <article class="thumb grid-item post-<?php echo $post_id; ?>">
                            <div class="halim-item">
                                <a class="halim-thumb" href="<?php echo $permalink; ?>" title="<?php echo esc_attr($title); ?>">
                                    <figure class="<?php echo $class; ?>">
                                        <div class="halim-trending-poster-mask halim-trending-<?php echo $class ?>"></div>
                                        <img class="blur-up img-responsive lazyautosizes lazyloaded" src="<?php echo $thumbnail; ?>"
                                            alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>">
                                        <div class="halim-trending-rating">
                                            <div class="halim-trending-rating-value">
                                                <?php echo halim_rate($post_id); ?>
                                            </div>

                                        </div>
                                    </figure>

                                    <div class="icon_overlay"></div>
                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title-box">

                                            <div class="number">
                                                <?php echo $item_counter ?></php>
                                            </div>
                                            <div class="halim-post-title ">
                                                <h2 class="entry-title"><?php echo $title; ?></h2>
                                                <p class="original_title">
                                                    <?php echo get_post_meta($post_id, '_halim_metabox_options', true)['halim_original_title'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        <?php
                        // HaLimCore::display_post_items('', true);
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
            <script>
                jQuery(document).ready(function ($) {
                    var owl = $('#<?php echo $widget_id; ?>');
                    owl.owlCarousel({ rtl: <?php echo is_rtl() ? "true" : "false"; ?>, loop: false, margin: 4, autoplay: false, autoplayTimeout: 4000, autoplayHoverPause: true, nav: false, navText: [], responsiveClass: true, responsive: { 0: { items: 2 }, 480: { items: 3 }, 600: { items: 4 }, 1000: { items: <?php echo $item ?> } } })
                });
            </script>
        </div>
        <?php
        echo $after_widget;
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['type'] = $new_instance['type'];
        $instance['categories'] = $new_instance['categories'];
        $instance['postnum'] = $new_instance['postnum'];
        $instance['item'] = $new_instance['item'];
        $instance['url'] = $new_instance['url'];
        $instance['rand'] = $new_instance['rand'];
        return $instance;
    }

    public function form($instance)
    {
        // Defaults
        $instance = wp_parse_args((array) $instance, array(
            'title' => __('Title', 'halimthemes'),
            'layout' => '4col',
            'postnum' => 8,
            'item' => 6,
            'type' => 'featured'
        ));
        extract($instance); ?>
        <div class="hl_slider_form">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                    name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('See more URL', 'halimthemes') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>"
                    name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
            </p>
            <p>
                <label><?php _e('Display by', 'halimthemes') ?></label>
                <br>
                <?php
                $f = array('featured' => __('Featured', 'halimthemes'), 'slidercat' => __('Category', 'halimthemes'));
                foreach ($f as $x => $n) { ?>
                    <label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>"
                        style="float: left;margin: 5px;display: inline-block;width: 45%;">
                        <input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" class="<?php echo $x ?>"
                            name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) {
                                      checked($x, $type, true);
                                  } ?> /> <?php echo $n ?>
                    </label>
                <?php } ?>
            </p>
            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', function (e) {
                        var $sliderthis = $(e.target);
                        var $sliderform = $sliderthis.closest('.hl_slider_form');

                        if ($sliderthis.is('.slidercat')) {
                            var $slider = $sliderform.find('.slider-category');
                            var sliderval = $sliderthis.is(':checked');
                            if (sliderval) {
                                $slider.slideDown();
                            }
                        } else if ($sliderthis.is('.featured')) {
                            var $slider = $sliderform.find('.slider-category');
                            var sliderval = $sliderthis.is(':checked');
                            if (sliderval) {
                                $slider.slideUp();
                            }
                        }
                    });

                    if ($("input.slidercat").is(':checked')) {
                        if ($('input.slidercat:checked').val() == 'slidercat') {
                            $('.slider-category').slideDown();
                        }
                    }
                });
            </script>
            <br>
            <p class="randomx" style="clear: both; display:block;">
                <label for="<?php echo $this->get_field_id("rand"); ?>_rand">
                    <input id="<?php echo $this->get_field_id("rand"); ?>_rand" class="rand"
                        name="<?php echo $this->get_field_name("rand"); ?>" type="checkbox" value="1" <?php if (isset($instance['rand'])) {
                               checked($instance['rand'], 1);
                           } ?> />
                    <?php _e('Random post', 'halimthemes') ?>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('item'); ?>">
                    <?php _e('Post item per row', 'halimthemes') ?> tối đa 9 post </label>
                <br />
                <input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('item'); ?>"
                    name="<?php echo $this->get_field_name('item'); ?>" value="<?php echo $instance['item']; ?>" />
            </p>
            <p class="slider-category" style="display: none;">
                <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Category', 'halimthemes') ?></label>
                <select id="<?php echo $this->get_field_id('categories'); ?>"
                    name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
                    <option value='all' <?php if ('all' == $instance['categories'])
                        echo 'selected="selected"'; ?>>
                        <?php _e('All category', 'halimthemes') ?>
                    </option>
                    <?php $categories = get_categories('hide_empty=1&depth=1&type=post'); ?>
                    <?php foreach ($categories as $category) { ?>
                        <option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories'])
                               echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?> [<?php echo $category->count ?>]
                        </option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label
                    for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
                <br />
                <input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>"
                    name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
            </p>
        </div>
        <?php
    }
}

function _HaLim_Carousel_Slider_Widget_Chill()
{
    register_widget('HaLim_Carousel_Slider_Widget_Chill');
}

add_action('widgets_init', '_HaLim_Carousel_Slider_Widget_Chill');

