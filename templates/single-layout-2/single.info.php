<?php

$episode = get_query_var('halim_episode');
$episode_slug = get_query_var('episode_slug');
$server = get_query_var('halim_server');
$type_slug = cs_get_option('halim_url_type');
$watch_slug = cs_get_option('halim_watch_url');
$episode_slug = cs_get_option('halim_episode_url');
$server_slug = cs_get_option('halim_server_url');
$post_slug = basename(get_permalink($post->ID));
$episode_display = cs_get_option('halim_episode_display');
$meta = get_post_meta($post->ID, '_halim_metabox_options', true);
$org_title = isset($meta['halim_original_title']) && $meta['halim_original_title'] != '' ? $meta['halim_original_title'] : '';
$quality = isset($meta['halim_quality']) && $meta['halim_quality'] != '' ? $meta['halim_quality'] : '';
$halim_episode = isset($meta['halim_episode']) && $meta['halim_episode'] != '' ? $meta['halim_episode'] : '';
$halim_total_episode = isset($meta['halim_episode']) && $meta['halim_episode'] != '' ? $meta['halim_total_episode'] : '';
$runtime = isset($meta['halim_runtime']) && $meta['halim_runtime'] != '' ? $meta['halim_runtime'] : '';
$imdb_rating = isset($meta['halim_rating']) && $meta['halim_rating'] ? $meta['halim_rating'] : '';
$imdb_votes = isset($meta['halim_votes']) && $meta['halim_votes'] ? $meta['halim_votes'] : '';
$trailer = isset($meta['halim_trailer_url']) ? $meta['halim_trailer_url'] : '';
$is_copyright = isset($meta['is_copyright']) ? $meta['is_copyright'] : '';
$is_adult = isset($meta['is_adult']) ? $meta['is_adult'] : '';
$time = explode(' ', esc_html($post->post_date));
$date = $time[0];
if ($trailer != '') {
    if (strpos($trailer, 'imdb.com')) {
        preg_match('/\/video\/imdb\/(.*?)\//is', $trailer, $imdb_embed);
        $trailer_url = 'https://www.imdb.com/videoembed/' . $imdb_embed[1];
    } else {
        $yt_id = HALIMHelper::getYoutubeId($trailer);
        $trailer_url = 'https://www.youtube.com/embed/' . $yt_id;
    }
} else
    $trailer_url = '';
?>
<script>
    var DoPostInfo = {
        id: "<?php echo get_the_ID(); ?>",
        url: "<?php echo get_permalink(); ?>",
        name: "<?php echo esc_js(get_the_title()); ?>",
        image: "<?php echo esc_url(halim_image_display()); ?>",
        ep_name: ""
    };
</script>
<div class="halim-movie-wrapper tpl-2">
    <div class="movie_info col-xs-12">
        <?php
        $poster = isset($meta['halim_poster_url']) && $meta['halim_poster_url'] != '' ? $meta['halim_poster_url'] : halim_image_display('full');
        $check = isset($meta['halim_movie_status']) ? $meta['halim_movie_status'] : '';
        if ($check == 'trailer')
            echo '<span class="trailer-button">' . __('Trailer', 'halimthemes') . '</span>';
        $the_title = cs_get_option('display_custom_title') ? halim_get_the_title($post->ID) : get_the_title($post->ID);
        ?>
        <div class="head ah-frame-bg">
            <div class="first">
                <img src="<?php echo halim_image_display('movie-thumb'); ?>" alt="<?php the_title() ?>">
            </div>
            <div class="last">
                <div class="name">
                    <div>Tên</div>
                    <div>
                        <h1 class="movie_name"><?php the_title() ?></h1>
                    </div>
                </div>
                <div class="name_other">
                    <div>Tên Khác</div>
                    <div>
                        <?php if ($org_title)
                            echo '<p class="org_title">' . $org_title . '</p>'; ?>

                    </div>
                </div>
                <div class="list_cate">
                    <div>Thể Loại</div>
                    <div>
                        <?php the_category(' '); ?>
                    </div>

                </div>
                <div class="hh3d-new-ep">
                    <div>Tập mới nhất</div>
                    <div><span
                            class="new-ep"><?php echo $halim_episode ? $halim_episode : halim_add_episode_name_to_the_title(halim_get_last_episode($post->ID)); ?>
                        </span></div>
                </div>
                <div class="hh3d-info">
                    <div>Thông Tin Khác</div>
                    <div><span class="released"><?php
                    if (has_term('', 'release')) {
                        $term_obj_list = get_the_terms($post->ID, 'release');
                        $released = $term_obj_list[0];
                        echo '<span class="released"><i class="hl-calendar"></i> <a href="' . home_url('/') . $released->taxonomy . '/' . trim($released->slug) . '" rel="tag">' . $released->name . '</a></span>';
                    } ?>
                            <?php echo $halim_total_episode ? '<i class="hl-clock"></i> ' . $halim_total_episode . ' Tập' : ''; ?>
                            <?php echo $imdb_rating ? '<i class="imdb-icon" data-rating="' . $imdb_rating . '"></i>' : ''; ?>
                    </div>
                </div>
                <div class="hh3d-rate">
                    <div>Đánh Giá</div>
                    <div class="ratings_wrapper single-info">
                        <div class="halim-rating-container">
                            <!-- <div class="halim-star-rating"> <span class="halim-star-icon">★</span> <span
                            
                                    class="halim-rating-score">4.15</span> <span class="halim-rating-slash">/</span>
                                <span class="halim-rating-max">5</span> <span class="halim-rating-votes">(14018
                                    lượt)</span>
                            </div> -->
                            <?php echo halim_get_user_rate() ?>
                            <button type="button" class="halim-rating-button" data-post-id="1183" data-rating="4.15"
                                data-votes="14018" data-title="Thần Ấn Vương Tọa">Đánh Giá</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="movie-poster col-md-4">
            <img class="movie-thumb" src="<?php echo halim_image_display('movie-thumb'); ?>" alt="<?php the_title() ?>">
            <?php if ($trailer_url): ?>
                <span id="show-trailer" data-url="<?php echo $trailer_url; ?>" class="btn btn-sm btn-primary show-trailer">
                    <i class="hl-youtube-play"></i> <?php _e('Trailer', 'halimthemes'); ?></span>
            <?php endif; ?>

            <div id="bookmark" data-toggle="tooltip" data-placement="right"
                data-original-title="<?php _e('Add to favorite', 'halimthemes'); ?>"
                class="halim_bookmark bookmark-img-animation primary_ribbon" data-post_id="<?php echo $post->ID; ?>"
                data-thumbnail="<?php echo esc_url(halim_image_display()) ?>" data-href="<?php the_permalink(); ?>"
                data-title="<?php echo $post->post_title; ?>" data-date="<?php echo $date; ?>">
                <div class="xhalim-pulse-ring"></div>
            </div>
            <?php if (!$is_copyright):

                $watch_url = cs_get_option('watch_btn_display') == 'first_episode' ? halim_get_first_episode_link($post->ID) : halim_get_last_episode_link($post->ID);
                ?>


                <div class="halim-watch-box">
                    <a href="<?php echo $watch_url; ?>" class="btn btn-sm btn-danger watch-movie visible-xs-blockx"><i
                            class="hl-play"></i> <?php _e('Watch', 'halimthemes'); ?></a>
                    <span class="btn btn-sm btn-success quick-eps" data-toggle="collapse" href="#collapseEps"
                        aria-expanded="false" aria-controls="collapseEps"><i class="hl-sort-down"></i>
                        <?php _e('Episodes', 'halimthemes'); ?></span>
                </div>
            <?php else: ?>
                <span class="btn btn-sm btn-danger watch-movie visible-xs-blockx" data-toggle="tooltip"
                    title="<?php _e('Copyright infringement!', 'halimthemes'); ?>"
                    style="width: 92%;"><?php _e('Copyright infringement!', 'halimthemes'); ?></span>
            <?php endif; ?>


        </div> -->

        <!-- <div class="film-poster col-md-8">
            <div class="movie-detail">
                <h1 class="entry-title"><?php echo $the_title ?></h1>
                <?php if ($org_title)
                    echo '<p class="org_title">' . $org_title . '</p>'; ?>

                <p class="released">
                    <?php
                    if (has_term('', 'release')) {
                        $term_obj_list = get_the_terms($post->ID, 'release');
                        $released = $term_obj_list[0];
                        echo '<span class="released"><i class="hl-calendar"></i> <a href="' . home_url('/') . $released->taxonomy . '/' . trim($released->slug) . '" rel="tag">' . $released->name . '</a></span>';
                    } ?>
                    <?php echo $runtime ? '<i class="hl-clock"></i> ' . $runtime : ''; ?>
                    <?php echo $imdb_rating ? '<i class="imdb-icon" data-rating="' . $imdb_rating . '"></i>' : ''; ?>
                </p>

                <?php if (HALIMHelper::is_type('tv_series') && !$is_copyright): ?>
                    <p class="episode">
                        <span><?php _e('Now showing', 'halimthemes'); ?>: </span>
                        <span><?php echo $halim_episode ? $halim_episode : halim_add_episode_name_to_the_title(halim_get_last_episode($post->ID)); ?></span>
                    </p>
                    <?php
                    if (is_halim_country_blocker($post->ID))
                        echo halim_get_three_last_episode($post->ID); ?>
                    <?php
                    //if( function_exists('halim_country_blocker') && !halim_country_blocker($post->ID) ) echo halim_get_three_last_episode($post->ID); ?>
                <?php endif; ?>

                <?php if (halim_get_country()): ?>
                    <p class="actors"><?php _e('Country', 'halimthemes'); ?>: <?php echo halim_get_country(); ?></p>
                <?php endif; ?>
                <?php if (halim_get_directors()): ?>
                    <p class="directors"><?php echo _e('Director', 'halimthemes'); ?>: <?php echo halim_get_directors(); ?>
                    </p>
                <?php endif; ?>
                <?php if (halim_get_actors()): ?>
                    <p class="actors"><?php _e('Actors', 'halimthemes'); ?>: <?php echo halim_get_actors(); ?></p>
                <?php endif; ?>

                <p class="category"><?php _e('Genres', 'halimthemes'); ?>: <?php the_category(', '); ?></p>

                <div class="ratings_wrapper single-info">
                    <?php echo halim_get_user_rate() ?>
                </div>
            </div>
        </div> -->
    </div>
    <div class="clearfix"></div>
    <div class="flex ah-frame-bg flex-wrap">
        <?php if (!$is_copyright)

            $watch_url = cs_get_option('watch_btn_display') == 'first_episode' ? halim_get_first_episode_link($post->ID) : halim_get_last_episode_link($post->ID);
        ?>
        <div class="flex flex-wrap flex-1"> <a href="<?php echo $watch_url; ?>"
                class="button-default fw-500 fs-15 flex flex-hozi-center bg-lochinvar watch-btn"> <svg
                    style="color:#fff;" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="currentColor"
                    width="20" height="20"
                    viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M320 112C434.9 112 528 205.1 528 320C528 434.9 434.9 528 320 528C205.1 528 112 434.9 112 320C112 205.1 205.1 112 320 112zM320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM276.5 211.5C269.1 207 259.8 206.8 252.2 211C244.6 215.2 240 223.3 240 232L240 408C240 416.7 244.7 424.7 252.3 428.9C259.9 433.1 269.1 433 276.6 428.4L420.6 340.4C427.7 336 432.1 328.3 432.1 319.9C432.1 311.5 427.7 303.8 420.6 299.4L276.6 211.4zM362 320L288 365.2L288 274.8L362 320z" />
                </svg>Xem Phim </a></div>
        <div class="last">

            <div id="bookmark4" class="button-default fw-500 fs-15 flex flex-hozi-center bg-lochinvar">
                <svg style="color:#fff;" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="currentColor"
                    width="20" height="20"
                    viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M192 64C156.7 64 128 92.7 128 128L128 544C128 555.5 134.2 566.2 144.2 571.8C154.2 577.4 166.5 577.3 176.4 571.4L320 485.3L463.5 571.4C473.4 577.3 485.7 577.5 495.7 571.8C505.7 566.1 512 555.5 512 544L512 128C512 92.7 483.3 64 448 64L192 64z" />
                </svg>
                <div id="bookmark" ddata-action="follow" data-placement="right" data-post_id="<?php echo $post->ID; ?>"
                    data-thumbnail="<?php echo esc_url(halim_image_display()) ?>" data-href="<?php the_permalink(); ?>"
                    data-title="<?php echo $post->post_title; ?>" data-date="<?php echo $date; ?>">
                    Theo dõi
                </div>
                <!-- <div class="follow-btn">Theo Dõi</div> -->
            </div>
        </div>
    </div>
</div>


<div id="halim_trailer"></div>

<div class="collapse <?php echo cs_get_option('episode_list_display') == 'visible' ? 'in' : ''; ?>" id="collapseEps">
    <?php

    if (isEpisodePagenav($meta) || $episode_display == 'show_paging_eps') {
        HaLimCore_Helper::halim_episode_pagination($post->ID, $server, $episode, false);
    } elseif ($episode_display == 'show_tab_eps') {
        HaLimCore_Helper::halim_show_all_eps_table($post->ID, $server, $episode_slug);
    } else {
        HaLimCore_Helper::halim_show_all_eps_list($post->ID, $server, $episode_slug, true);
    }
    ?>
</div>

<div class="clearfix"></div>
<?php if (cs_get_option('single_notice')): ?>
    <div class="halim--notice">
        <p><?php echo cs_get_option('single_notice'); ?></p>
    </div>
    <?php
endif;
if (isset($meta['halim_movie_notice']) && $meta['halim_movie_notice'] != ''): ?>
    <div class="halim-film-notice">
        <p><?php echo $meta['halim_movie_notice']; ?></p>
    </div>
    <?php
endif;
if (isset($meta['halim_showtime_movies']) && $meta['halim_showtime_movies'] != ''): ?>
    <div class="halim_showtime_movies">
        <p><?php echo $meta['halim_showtime_movies']; ?></p>
    </div>
<?php endif; ?>

<?php do_action('halim_before_single_content', $post->ID); ?>

<div class="entry-content-child htmlwrap clearfix">
    <div class="section-title"><span><?php _e('Movie plot', 'halimthemes'); ?></span></div>
    <div class="video-item halim-entry-box">
        <article id="post-<?php echo $post->ID; ?>"
            class="item-content <?php echo cs_get_option('post_content_display_detail_page') == 'visible' ? 'toggled' : ''; ?>">
            <?php the_content(); ?>
        </article>
        <div class="item-content-toggle">
            <span class="show-more" data-single="true" data-showmore="<?php _e('Show more', 'halimthemes'); ?>..."
                data-showless="<?php _e('Show less', 'halimthemes'); ?>..."><?php $txt = cs_get_option('post_content_display_detail_page') == 'visible' ? 'Show less' : 'Show more';
                   _e($txt, 'halimthemes'); ?>...</span>
        </div>
    </div>
</div>

<?php
if (comments_open() || get_comments_number()) {
    echo '<div class="entry-content-child htmlwrap clearfix"> ' . comments_template() . ' </div>';

}
?>

<?php do_action('halim_after_single_content', $post->ID); ?>