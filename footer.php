</div>
</div><!--./End .container -->
    <?php if(cs_get_option('enable_footer_banner_ads')) : ?>
    	<div class="container">
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0 -10px;">
		        <?php echo cs_get_option('footer_banner_ads'); ?>
		    </div>
    	</div>
    <?php endif; ?>
<div class="clearfix"></div>
<?php $options = get_option('halim_options', true); ?>
<footer id="footer" class="clearfix">
	<div class="container footer-columns">
		<div class="row container">
			<!-- <div class="widget about col-xs-12 col-sm-4 col-md-4">
				<div class="footer-logo">
	              <?php
	      			$logo = wp_get_attachment_image_src(cs_get_option('footer_logo'), 'full');
	      			if ($logo): ?>
	              <img class="img-responsive" src="<?php echo esc_attr($logo[0]); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
	              <?php endif?>
					<span class="social">
						<?php if(cs_get_option('halim_fb_profile_url')) : ?>
						<a href="<?php echo cs_get_option('halim_fb_profile_url'); ?>" target="_blank" rel="nofollow"><i class="hl-facebook"></i></a>
						<?php endif;
						   if(cs_get_option('halim_gplus_url')) : ?>
						<a href="<?php echo cs_get_option('halim_gplus_url'); ?>" target="_blank" rel="nofollow"><i class="hl-gplus"></i></a>
						<?php endif;
						   if(cs_get_option('halim_twitter_url')) : ?>
						<a href="<?php echo cs_get_option('halim_twitter_url'); ?>" target="_blank" rel="nofollow"><i class="hl-twitter"></i></a>
						<?php endif;
							if(cs_get_option('halim_pinterest_url')) : ?>
						<a href="<?php echo cs_get_option('halim_pinterest_url'); ?>" target="_blank" rel="nofollow"><i class="hl-pinterest"></i></a>
						<?php endif; ?>
					</span>
				</div>
				<?php if(cs_get_option('footer_about_text') !== NULL) echo '<p class="halim-about">'.cs_get_option('footer_about_text').'</p>'; ?>
			</div> -->
			<?php dynamic_sidebar( 'footer' ); ?>
		</div>
	</div>
</footer>
<div class="footer-credit">
	<div class="container credit">
		<div class="row container">
			<div class="col-xs-12 col-sm-4 col-md-6">
				<a href="/" title='<?php bloginfo( 'name' )?>'><?php echo halim_footer_copyright(); ?>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-6 text-right pull-right">
				<p class="blog-info">
		            <?php echo (cs_get_option('footer_right_text') !== NULL) ? cs_get_option('footer_right_text') : bloginfo( 'name' );;
					?>
				</p>
			</div>
		</div>
	</div>
</div>

<div id='easy-top'></div>
<?php wp_footer(); if (cs_get_option('footer_code')) echo cs_get_option('footer_code')."\n"; ?>
<script data-cfasync="false" async type="text/javascript" src="//pr.foemanearbash.com/rv8B7LLt8d93dX4K/80133"></script>
</body>
</html>