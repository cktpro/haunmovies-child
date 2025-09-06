<?php

class HaLim_Advanced_Widget_Child extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'halim-advanced-widget-child',
			__('HaLim Advanced Widget Child', 'halimthemes'),
			array(
				'classname' => 'halim-advanced-widget-child',
				'description' => __('Hiển thị phim cùng với lịch chiếu', 'halimthemes')
			)
		);
	}


	public function widget($args, $instance)
	{

		extract($args);
		extract($instance);
		echo $before_widget;
		ob_start();
		?>
		<section id="<?php echo $widget_id; ?>" class="halim-showtim">

			<h4 class="section-heading">
				<a href="<?php echo ($categories == 'all') ? $url : get_category_link($categories); ?>"
					title="<?php echo $title; ?>">
					<span class="h-text"><?php echo $title; ?></span>
				</a>
				<?php
				// $cat_id = array();
				// if (isset($tabs)) {
				// 	echo '<ul class="heading-nav pull-right hidden-xs">';
				// 	foreach ($tabs as $l) {
				// 		$cat_id[] = $l;
				// 	}
				// 	foreach ($cat_id as $p => $k) {
				// 		echo '<li class="section-btn halim_ajax_get_post" data-catid="' . $k . '" data-showpost="' . $postnum . '" data-widgetid="' . $args['widget_id'] . '" data-layout="' . $instance['layout'] . '"><span data-text="' . get_the_category_by_ID($k) . '"></span></li>';
				// 	}
				// 	echo '</ul>';
				// }
				$day_of_week = array(
					array(
						'id' => 1,
						'name' => 'Thứ 2',
						'value' => 'Monday',
						'slug' => 'thu-2'
					),
					array(
						'id' => 2,
						'name' => 'Thứ 3',
						'value' => 'Tuesday',
						'slug' => 'thu-3'
					),
					array(
						'id' => 3,
						'name' => 'Thứ 4',
						'value' => 'Wednesday',
						'slug' => 'thu-4'
					),
					array(
						'id' => 4,
						'name' => 'Thứ 5',
						'value' => 'Thursday',
						'slug' => 'thu-5'
					),
					array(
						'id' => 5,
						'name' => 'Thứ 6',
						'value' => 'Friday',
						'slug' => 'thu-6'
					),
					array(
						'id' => 6,
						'name' => 'Thứ 7',
						'value' => 'Saturday',
						'slug' => 'thu-7'
					),
					array(
						'id' => 7,
						'name' => 'Chủ Nhật',
						'value' => 'Sunday',
						'slug' => 'chu-nhat'
					),
				);

				echo '<ul   class="nav nav-pills nav-justified halim-schedule-block">';
				echo '<li  class="halim_ajax_get_schedule active" data-catid="lastupdate" data-showpost="' . $postnum . '" data-widgetid="' . $args['widget_id'] . '" data-layout="' . $instance['layout'] . ' " data-day="lastupdate"><a href="#" role="tab" data-toggle="tab" aria-expanded="true">Mới Cập Nhật</a></li>';
				// echo '<li  class="halim_ajax_get_schedule dropdown" data-catid="lastupdate" data-showpost="' . $postnum . '" data-widgetid="' . $args['widget_id'] . '" data-layout="' . $instance['layout'] . ' " data-day="lich-chieu"><a href="#" role="tab" data-toggle="tab" aria-expanded="true">Lịch chiếu</a></li>';
				foreach ($day_of_week as $day) {
					$shortDay = substr($day['value'], 0, 3);
					echo '<li  class="halim_ajax_get_schedule" data-catid="' . $day['value'] . '" data-showpost="' . $postnum . '" data-widgetid="' . $args['widget_id'] . '" data-layout="' . $instance['layout'] . ' " data-day="' . $day['slug'] . '"><a href="#' . $day['slug'] . '"  role="tab" data-toggle="tab" aria-expanded="true"><span style="font-weight: 600;font-size: 16px;line-height: 1em;">' . $shortDay . '</br></span>' . $day['name'] . '</a></li>';
				}

				echo '</ul>';
				?>
			</h4>
			<div id="<?php echo $args['widget_id']; ?>" class="halim_box">
				<div class="tab-content">
					<?php
					if (get_query_var('paged')) {
						$paged = get_query_var('paged');
					} elseif (get_query_var('page')) { // 'page' is used instead of 'paged' on Static Front Page
						$paged = get_query_var('page');
					} else {
						$paged = 1;
					}
					$phim = [];
					$args2 = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 20,
						'orderby' => 'modified',
						'paged' => $paged,
					);
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => $postnum,

					);
					if ($rand == 1) {
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'status',
								'field' => 'slug',
								'terms' => 'ongoing',
								'operator' => 'IN'
							)
						);
					}
					;
					if ($type == 'popular') {
						$args['orderby'] = 'meta_value_num';
						$args['meta_query'] = array(
							array(
								'key' => 'halim_view_post_all'
							),
						);
					} elseif ($type == 'completed') {
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'status',
								'field' => 'slug',
								'terms' => 'completed',
								'operator' => 'IN'
							)
						);

					} elseif ($type == 'lastupdate') {
						$args['orderby'] = 'modified';
					}
					;
					foreach ($day_of_week as $index => $day) {
						$args['meta_query'] = array(
							array(
								'key' => '_halim_metabox_options',
								'value' => $day['name'],
								'compare' => 'LIKE'
							)
						);
						$query = new WP_Query($args);
						$phim[$index] = $query; {
							echo '<div role="tabpanel" class="tab-pane tab-schedule"  id="' . $day['slug'] . '">';
							if ($phim[$index]->have_posts()):
								while ($phim[$index]->have_posts()):
									$phim[$index]->the_post();
									HaLimCore::display_post_items($layout);
								endwhile;
								wp_reset_postdata();
							endif;
							echo '</div>';
						}
					}
					echo '<div role="tabpanel" class="tab-pane tab-schedule active"  id="lastupdate">';
					$querys = new WP_Query($args2);
					if ($querys->have_posts()):
						while ($querys->have_posts()):
							$querys->the_post();
							$post_id = get_the_ID();
							$title = get_the_title();
							$permalink = get_permalink();
							$thumbnail = get_the_post_thumbnail_url($post_id, 'full'); // size: medium, large, full
							$alt = esc_attr($title);
							$status = get_post_meta($post_id, '_halim_metabox_options', true)['halim_quality'] ?? 'Đang cập nhật';
							$episode = get_post_meta($post_id, '_halim_metabox_options', true)['halim_episode'] ?? 'Tập mới nhất';
							$org_title = get_post_meta($post_id, '_halim_metabox_options', true)['halim_original_title'] ?? '' ?>

							<article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-<?php echo $post_id; ?>">
								<div class="halim-item">
									<a class="halim-thumb" href="<?php echo $permalink; ?>" title="<?php echo esc_attr($title); ?>">
										<figure><img class="blur-up img-responsive lazyautosizes lazyloaded" alt="<?php echo $alt; ?>"
												title="<?php echo $alt; ?>" src="<?php echo $thumbnail; ?>">
										</figure>
										<!-- <span class="status"><?php echo $status ?></span>
										<span class="episode"><?php echo $episode ?></span> -->
										<span class="status"><?php echo $episode . ' [4k]' ?></span>
										<div class="icon_overlay">
										</div>

										<div class="halim-post-title-box">
											<div class="halim-post-title ">
												<h2 class="entry-title"><?php echo $title; ?></h2>
												<p class="original_title">
													<?php echo $org_title ?>
												</p>
											</div>
										</div>
									</a>
								</div>
							</article>
							<!-- HaLimCore::display_post_items($layout); -->
						<?php endwhile;
						wp_reset_postdata();
					endif;
					echo '<div class="clearfix"></div>';
					halim_pagination();
					echo '</div>';
					?>
					<div class="clearfix"></div>
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


	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = $new_instance['url'];
		$instance['tabs'] = $new_instance['tabs'];
		$instance['type'] = $new_instance['type'];
		$instance['rand'] = $new_instance['rand'];
		$instance['categories'] = $new_instance['categories'];
		$instance['postnum'] = $new_instance['postnum'];
		$instance['layout'] = $new_instance['layout'];
		return $instance;
	}

	public function form($instance)
	{

		$instance = wp_parse_args((array) $instance, array(
			'title' => __('Title', 'halimthemes'),
			'layout' => '4col',
			'postnum' => 8,
			'item' => 5,
			'type' => 'latest',
			'url' => '',
			'rand' => '',
			'tabs' => '',
			'categories' => 'all'
		));
		extract($instance); ?>
		<div class="hl_options_form">
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('View more URL', 'halimthemes') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>"
					name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>"
					placeholder="http://play.halimthemes.com/phim-moi/" />
			</p>
			<p style="display: inline-block;">
				<label><?php _e('Display posts by', 'halimthemes') ?></label>
				<br>
				<label for="<?php echo $this->get_field_id("type"); ?>_latest"
					style="float: left;margin: 5px;display: inline-block;width: 45%;">
					<input id="<?php echo $this->get_field_id("type"); ?>_latest" class="latest"
						name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="latest" checked />
					<?php _e('Latest', 'halimthemes') ?>
				</label>
				<?php
				$f = array(
					'categories' => __('Category', 'halimthemes'),
					'completed' => __('Completed', 'halimthemes'),
					'lastupdate' => __('Last update', 'halimthemes'),
					'popular' => __('Most viewed', 'halimthemes'),
					'tvseries' => __('TV Series', 'halimthemes'),
					'movies' => __('Movies', 'halimthemes'),
					'tv_shows' => __('TV Shows', 'halimthemes'),
					'theater_movie' => __(' Theater movie', 'halimthemes')
				);
				foreach ($f as $x => $n) { ?>
					<label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>"
						style="float: left;margin: 5px;display: inline-block;width: 45%;">
						<input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>"
							class="<?php echo $x == 'categories' ? $x . ' cat' : $x; ?>"
							name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) {
									  checked($x, $type, true);
								  } ?> /> <?php echo $n ?>
					</label>
				<?php } ?>
			</p>
			<script>
				jQuery(document).on('click', function (e) {
					var $this = jQuery(e.target);
					var $form = $this.closest('.hl_options_form');

					if ($this.is('.categories')) {
						var $halim = $form.find('.category');
						var val = $this.is(':checked');
						if (val) {
							$halim.slideDown();
						}
					} else if ($this.is('.popular, .latest, .tvseries, .movies, .lastupdate, .completed')) {
						var $halim = $form.find('.category');
						var val = $this.is(':checked');
						if (val) {
							$halim.slideUp();
						}
					}

					if ($this.is('.lastupdate')) {
						var $halim = $form.find('.random');
						var val = $this.is(':checked');
						if (val) {
							$halim.slideUp();
						}
					} else if ($this.is('.popular, .latest, .tvseries, .movies, .lastupdate, .completed')) {
						var $halim = $form.find('.random');
						var val = $this.is(':checked');
						if (val) {
							$halim.slideDown();
						}
					}

				});

				jQuery(document).ready(function ($) {
					if ($("input.lastupdate").is(':checked')) {
						if ($('input.lastupdate:checked').val() == 'lastupdate') {
							$('.random').slideUp();
						}
					}

					if ($("input.cat").is(':checked')) {
						if ($('input.cat:checked').val() == 'categories') {
							$('.category').slideDown();
						}
					}
				});
			</script>
			<br />
			<p class="random" style="clear: both; display:block;">
				<label for="<?php echo $this->get_field_id("rand"); ?>_rand">
					<input id="<?php echo $this->get_field_id("rand"); ?>_rand" class="rand"
						name="<?php echo $this->get_field_name("rand"); ?>" type="checkbox" value="1" <?php if (isset($rand)) {
							   checked($rand, 1);
						   } ?> /> <?php _e('Random post', 'halimthemes') ?>
				</label>
			</p>
			<br />
			<div class="hl_select_tabs" style="clear: both;border: 1px solid #f1f1f1;padding: 6px;background: #fdfdfd;">
				<h4 style="margin-top: 0;margin-bottom: 5px;"><?php _e('Sub category', 'halimthemes'); ?></h4>
				<div class="hl_select_tabs" style="max-height: 150px;overflow-x: auto;border: 1px solid #eee;padding: 5px;">
					<?php
					$showsubcat = get_categories('hide_empty=1&depth=1&hierarchical=1&type=post');
					foreach ($showsubcat as $getsubcat) { ?>
						<label for="<?php echo $this->get_field_id("tabs"); ?>_<?php echo $getsubcat->term_id; ?>" class="alignleft"
							style="display: block; width: 50%; margin-bottom: 5px;">
							<input type="checkbox" class="checkbox"
								id="<?php echo $this->get_field_id("tabs"); ?>_<?php echo $getsubcat->term_id; ?>"
								name="<?php echo $this->get_field_name("tabs"); ?>[<?php echo $getsubcat->term_id; ?>]"
								value="<?php echo $getsubcat->term_id; ?>" <?php if (isset($tabs[$getsubcat->term_id])) {
									   checked($getsubcat->term_id, $tabs[$getsubcat->term_id], true);
								   } ?> /><?php echo $getsubcat->cat_name; ?>
							[<?php echo $getsubcat->count ?>]
						</label>
					<?php }
					?>
				</div>
			</div>

			<p style="clear: both;">
				<label for="<?php echo $this->get_field_id('layout'); ?>">
					<?php _e('Layout', 'halimthemes') ?>
					<br />
					<select id="<?php echo $this->get_field_id('layout'); ?>"
						name="<?php echo $this->get_field_name('layout'); ?>" class="widefat">
						<?php
						$vl = array('4col' => __('4 item/row', 'halimthemes'), '6col' => __('6 item/row', 'halimthemes'));
						foreach ($vl as $layout_id => $layout_name) { ?>
							<option value="<?php echo $layout_id ?>" <?php selected($layout_id, $instance['layout'], true); ?>>
								<?php echo $layout_name ?>
							</option>
						<?php } ?>
					</select>
				</label>
			</p>
			<p class="category" style="display: none;">
				<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Category', 'halimthemes') ?></label>
				<select id="<?php echo $this->get_field_id('categories'); ?>"
					name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
					<option value='all' <?php if ('all' == $instance['categories'])
						echo 'selected="selected"'; ?>>All categories
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
