<?php

/**
 * Template Name: Showtime Films
 */
get_header(); ?>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
	<?php if (is_active_sidebar('halim-ad-above-category')) { ?>
		<div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
			<?php dynamic_sidebar('halim-ad-above-category'); ?>
		</div>
	<?php } ?>
	<section>
		<div class="section-bar clearfix">
			<h3 class="section-title">
				<span><?php _e('Lịch Chiếu Phim', 'halimthemes') ?></span>
			</h3>
		</div>
		<section class="halim-showtime">
			<?php
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

			echo '<div   class="schedule-menu nav-justified halim-schedule-block">';

			foreach ($day_of_week as $day) {
				if ($day['value'] == date('l')) {
					echo '<div  class="halim_ajax_get_schedule active schedule-item" data-catid="' . $day['value'] . '" data-day="' . $day['slug'] . '"><a href="#' . $day['slug'] . '"  role="tab" data-toggle="tab" aria-expanded="true" >' . $day['name'] . '</a></div>';
				} else
					echo '<div  class="halim_ajax_get_schedule schedule-item " data-catid="' . $day['value'] . '"   data-day="' . $day['slug'] . '"><a href="#' . $day['slug'] . '"  role="tab" data-toggle="tab" aria-expanded="true">' . $day['name'] . '</a></div>';
			}

			echo '</div>';
			?>
			<div id="<?php echo $args['widget_id']; ?>" class="halim_box">
				<div class="tab-content">
					<?php
					$phim = [];
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
						$phim[$index] = $query;
						if ($day['value'] == date('l')) {
							echo '<div role="tabpanel" class="tab-pane tab-schedule active"  id="' . $day['slug'] . '">';
							if ($phim[$index]->have_posts()):
								while ($phim[$index]->have_posts()):
									$phim[$index]->the_post();
									HaLimCore::display_post_items();
								endwhile;
								wp_reset_postdata();
							endif;
							echo '</div>';
						} else {
							echo '<div role="tabpanel" class="tab-pane tab-schedule"  id="' . $day['slug'] . '">';
							if ($phim[$index]->have_posts()):
								while ($phim[$index]->have_posts()):
									$phim[$index]->the_post();
									HaLimCore::display_post_items();
								endwhile;
								wp_reset_postdata();
							endif;
							echo '</div>';
						}
					}
					?>
				</div>

			</div>
		</section>
		<div class="clearfix"></div>
	</section>
	<!-- <?php if (is_active_sidebar('halim-ad-below-category')) { ?>
		<div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
			<?php dynamic_sidebar('halim-ad-below-category'); ?>
		</div>
	<?php } ?> -->
</main>
<?php get_sidebar();
get_footer(); ?>