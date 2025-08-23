<?php

	/**
	* Template Name: Top 10 Movies
	*/
	get_header();
	$type = isset($_GET['sortby']) ? $_GET['sortby'] : '';
?>
<main id="main-content" class="container">
	
	<section>
			<div class="section-bar clearfix">
			   <h3 class="section-title">
					<span><?php _e('Top 10 Phim Hay Nhất', 'halimthemes') ?></span>
			   </h3>
			</div>
			<div class="section-bar">
				<div class="halim_box_top_sortby">
				<a<?php echo $type == 'day' ? ' class="active"' : ''; ?> href="?sortby=day">Ngày</a>  <a<?php echo $type == 'week' ? ' class="active"' : ''; ?> href="?sortby=week">Tuần</a>  <a<?php echo $type == 'mon' ? ' class="active"' : ''; ?> href="?sortby=mon">Tháng</a>  <a<?php echo $type == '' ? ' class="active"' : ''; ?> href="<?php echo get_permalink(get_the_ID()); ?>">Tất cả</a>
				</div>
			</div>
			<div class="halim_box_top">
				
			<?php
				$post_format = halim_get_post_format_type($type);
				$args = array(
					'post_type'			=> 'post',
					'posts_per_page' 	=> 10,
					'post_status' 		=> 'publish',
					'orderby'        => 'meta_value_num',
    				'order'          => 'DESC',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key'   => 'halim_view_post_all'
						),
					)
				);
				if($type && $type != 'allpost') {
			        $args['meta_key'] = 'halim_view_post_'.$type; 
				}
				$wp_query = new WP_Query( $args );
				$count=1;
				if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
				$meta = get_post_meta(get_the_ID(), '_halim_metabox_options', true);
        		$original_title = $meta["halim_original_title"]; ?>
					<article class="flex-item thumb grid-item post-<?php the_ID(); ?>">
            <div class="halim-item">
                <a class="halim-thumb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <figure>
                        <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('medium', array('class'=>'img-responsive'));
                        }
                        ?>
                    </figure>
                    <div class="top-movies-status">
						<span class="status-number <?php 
							if($count === 1) echo 'top1';
							elseif($count === 2) echo 'top2';
							elseif($count === 3) echo 'top3';
													?>">
							<?php echo $count; ?>
						</span>
					</div>
                    <div class="icon_overlay"></div>
                    <div class="halim-post-title-box">
                        <div class="halim-post-title">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                            <?php if($original_title) : ?>
                                <p class="original_title"><?php echo $original_title ?></p>
                            <?php $count++; endif; ?>
                        </div>
                    </div>
                </a>
            </div>
        </article>
		<?php
				endwhile; wp_reset_postdata(); endif; ?>
			</div>
		<div class="clearfix"></div>
	</section>
</main>
<?php  get_footer(); ?>