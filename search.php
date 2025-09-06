<?php get_header(); ?>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
	<section>
		<?php if ( is_active_sidebar( 'halim-ad-above-category' ) ) { ?>
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
		        <?php dynamic_sidebar( 'halim-ad-above-category' ); ?>
		    </div>
		<?php } ?>
		<h1 class="page-title hidden"><?php printf( __( 'Search Results for: %s', 'halimthemes' ), get_search_query() ); ?></h1>
		<div class="section-bar clearfix">
		   <h3 class="section-title">
			<span><?php printf( __( 'Search Results for: %s', 'halimthemes' ), get_search_query() ); ?></span>
		   </h3>
		</div>
		<div class="halim_box">
			<?php
				if(have_posts()): while(have_posts()): the_post();
					HaLimCore::display_post_items();
			endwhile; ?>
		</div>
		<?php endif; halim_pagination(); ?>
		<?php if ( is_active_sidebar( 'halim-ad-below-category' ) ) { ?>
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
		        <?php dynamic_sidebar( 'halim-ad-below-category' ); ?>
		    </div>
		<?php } ?>
	</section>
</main>
<?php get_sidebar(); get_footer(); ?>