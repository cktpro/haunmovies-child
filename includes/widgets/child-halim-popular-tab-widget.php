<?php

class child_halim_tab_popular_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'child_halim_tab_popular_videos-widget',
			__( 'HaLim Polpular Movies', 'halimthemes' ),
			array(
				'classname'   => 'child_halim_tab_popular_videos-widget',
				'description' => __( 'Display popular post by day, week, month and alltime sss', 'halimthemes' )
			)
		);
	}

	function widget($args, $instance)
	{
		global $post;
		extract($args);
		$title = $instance['title'];
		$postnum = $instance['postnum'];
		echo $before_widget;
		if($title != '') :
		ob_start();
		?>
			<div class="section-bar clearfix">
				<div class="section-title">
					<span><?php echo $title; ?></span>
				</div>
			</div>
		<?php endif ?>
	   <section class="tab-content">
			<div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div id="halim-ajax-popular-post" class="popular-post">
					<?php
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $postnum,
							'orderby' => 'meta_value_num',
							'meta_query' => array(
								'relation' => 'AND',
								array(
									'key'   => 'halim_view_post_day'
								),
							),
						);
						$day = new WP_Query( $args );
						if ($day->have_posts()) : while ($day->have_posts()) : $day->the_post();
						// Hiển thị các bài viết phổ biến theo ngày không hiển thị lượt xem
						
						$post_id = get_the_ID();
        $title = get_the_title();
        $permalink = get_permalink();
		$meta = get_post_meta($post_id, '_halim_metabox_options', true);
        $original_title = $meta["halim_original_title"]; // nếu lưu tên gốc
        $thumbnail = has_post_thumbnail() 
            ? get_the_post_thumbnail_url($post_id, 'medium') 
            : get_stylesheet_directory_uri() . '/images/default-thumbnail.jpg';
        ?>
        <div class="item post-<?php echo $post_id; ?>">
            <a class="thumbnail-link" title="<?php echo esc_attr($title); ?>" href="<?php echo esc_url($permalink); ?>" rel="bookmark">
                <div class="item-link">
                    <img width="65" height="80" src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>" class="wp-post-image img-responsive">
                </div>
                <h3 class="title"><?php echo esc_html($title); ?></h3>
                <?php if ($original_title) : ?>
                    <p class="original_title"><?php echo esc_html($original_title); ?></p>
                <?php endif; ?>
            </a>
        </div>
        <?php
						endwhile; endif; wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	<?php
		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['postnum'] = $new_instance['postnum'];
		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			'title' 		=> __('Popular', 'halimthemes'),
			'postnum' 		=> 6,
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes') ?></label>
			<br />
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
			<br />
			<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
		</p>
	<?php
	}
}