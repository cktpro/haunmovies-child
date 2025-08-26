<?php

/**
 * Template Name: Bookmark
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
				<span><?php _e('Bookmark', 'halimthemes') ?></span>
			</h3>
		</div>
		<div id="bookmark-list4" class="halim_box"></div>
		<div class="clearfix"></div>

	</section>
	<?php if (is_active_sidebar('halim-ad-below-category')) { ?>
		<div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
			<?php dynamic_sidebar('halim-ad-below-category'); ?>
		</div>
	<?php } ?>

</main>
<?php get_sidebar();
get_footer(); ?>