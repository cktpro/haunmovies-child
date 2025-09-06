<?php

    $episode         = get_query_var('halim_episode');
    $server          = get_query_var('halim_server');
    $episode_display = cs_get_option('halim_episode_display');
    $meta            = get_post_meta($post->ID, '_halim_metabox_options', true );
    $time            = explode(' ', esc_html($post->post_date));
    $date            = $time[0];
    $episode_slug = get_query_var('episode_slug') ? wp_strip_all_tags(get_query_var('episode_slug')) : '';
    if (have_posts()): while (have_posts()): the_post();
        ?>

        <div class="clearfix"></div>
        <?php dynamic_sidebar('halim-ad-above-player') ?>
        <div class="clearfix"></div>
            <?php do_action('halim_player_default', $meta); ?>
        <div class="clearfix"></div>
        <?php dynamic_sidebar('halim-ad-below-player') ?>
        <div class="clearfix"></div>
        <div class="title-block watch-page">
            <a href="javascript:;" data-toggle="tooltip" title="<?php _e('Add to favorite', 'halimthemes'); ?>">
                <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-post_id="<?php echo $post->ID; ?>" data-thumbnail="<?php echo esc_url(halim_image_display()) ?>" data-href="<?php the_permalink(); ?>" data-title="<?php echo $post->post_title; ?>" data-date="<?php echo $date; ?>">
                </div>
            </a>
            <div class="title-wrapper full">
                <?php echo '<h1 class="entry-title"><a href="'.get_the_permalink().'" title="'.halim_get_the_title($post->ID).'" class="tl">'.halim_get_the_title($post->ID).'</a></h1>'; ?>

                <span class="plot-collapse" data-toggle="collapse" data-target="#expand-post-content" aria-expanded="false" aria-controls="expand-post-content" data-text="<?php _e('Movie plot', 'halimthemes'); ?>"><i class="hl-angle-down"></i></span>
            </div>

            <div class="ratings_wrapper">
                <?php echo halim_get_user_rate(); ?>
            </div>

        </div>

        <?php do_action('halim_before_single_watch_content', $post->ID); ?>

        <div class="entry-content htmlwrap clearfix collapse <?php echo cs_get_option('post_content_display_watch_page') == 'visible' ? 'in' : ''; ?>" id="expand-post-content">
            <article id="post-<?php echo $post->ID; ?>" class="item-content post-<?php echo $post->ID; ?>">
                <?php the_content(); ?>
            </article>
        </div>
        <div class="clearfix"></div>
        <?php
            if(isEpisodePagenav($meta) || $episode_display == 'show_paging_eps') {
                HaLimCore_Helper::halim_episode_pagination($post->ID, $server, $episode, false);
            } elseif ($episode_display == 'show_tab_eps') {
                HaLimCore_Helper::halim_show_all_eps_table($post->ID, $server, $episode_slug);
            } else {
                HaLimCore_Helper::halim_show_all_eps_list($post->ID, $server, $episode_slug, true);
            }
        ?>
        <div class="clearfix"></div>

        <?php do_action('halim_after_single_watch_content', $post->ID); ?>

        <?php
            endwhile;
    endif;

    if(cs_get_option('enable_fb_comment') == 1) : ?>
        <div class="htmlwrap fb-comment clearfix">
            <div class="fb-comments" data-href="<?php the_permalink(); ?>/" data-width="100%" data-mobile="true" data-colorscheme="dark" data-numposts="<?php echo cs_get_option('fb_comment_display'); ?>" data-order-by="<?php echo cs_get_option('fb_comment_order_by'); ?>" data-lazy="true"></div>
        </div>
    <?php endif;

    if ( cs_get_option('enable_site_comment') == 1 && comments_open()) :
        if(class_exists('WpdiscuzCore')) {
            comments_template();
        } else {
            echo '<div class="halim--notice">This theme requires the following plugin: <a href="https://wordpress.org/plugins/wpdiscuz/" rel="nofollow" target="_blank">wpDiscuz Comments</a></div>';
        }
    endif;

    if(cs_get_option('enable_disqus_comment') == 1) : ?>

        <div class="htmlwrap clearfix">
            <div id="disqus_thread"></div>
            <script>
                var disqus_shortname = '<?php echo cs_get_option('disqus_shortname'); ?>';
                (function() {
                    var dsq = document.createElement('script'); dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>

        </div>
    <?php endif; ?>
    <div id="lightout"></div>
    <script>
var DoPostInfo = {
    id: "<?php echo get_the_ID(); ?>",
    url: "<?php echo get_permalink(); ?>",
    name: "<?php echo esc_js(get_the_title()); ?>",
    image: "<?php echo esc_url(halim_image_display()); ?>",
    ep_name: "Tập <?php echo $episode_slug ?>"
};
</script>
