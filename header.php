<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#234556">
    <meta name="msapplication-navbutton-color" content="#234556">
    <meta name="apple-mobile-web-app-status-bar-style" content="#234556">
    <?php if (cs_get_option('favicon')): ?>
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url(cs_get_option('apple_touch_icon')); ?>" />
    <link rel="shortcut icon" href="<?php echo esc_url(cs_get_option('favicon')); ?>" type="image/x-icon" />
    <?php else: ?>
    <link rel="shortcut icon" href="<?php echo HALIM_THEME_URI ?>/assets/images/favicon.ico" type="image/x-icon" />
    <?php endif;
        wp_head();
        if (cs_get_option('header_code')) echo cs_get_option('header_code')."\n";
        $logo = '';
        if(cs_get_option('site_logo'))
            $logo = wp_get_attachment_image_src(cs_get_option('site_logo'), 'full')[0];
    if($logo) : ?>
        <style>#header .site-title {background: url(<?php echo esc_attr($logo); ?>) no-repeat top left;background-size: contain;text-indent: -9999px;}</style>
    <?php else: ?>
        <style>#header .site-title {background: url(<?php echo HALIM_THEME_URI ?>/assets/images/halim-dark-logo.png) no-repeat top left;background-size: contain;text-indent: -9999px;}</style>
    <?php endif; ?>
</head>
<body <?php body_class('halimmovie-version-'.HALIMMOVIE_VERSION); ?> data-masonry="<?php echo cs_get_option('masonry_grid'); ?>" data-nonce="<?php echo wp_create_nonce(get_the_ID()); ?>">
<?php
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }
    $postCount = __('Search', 'halimthemes');
    if(cs_get_option('show_total_post_in_search_form')) {
        $count_posts = wp_count_posts();
        if ( $count_posts ) {
            $postCount = number_format($count_posts->publish);
        }
    }
?>
    <header id="header">
        <div class="container">
            <div class="row" id="headwrap">
                <div class="col-md-3 col-sm-6 slogan">
                    <?php if ( is_front_page() ) : ?>
                        <h1 class="site-title"><a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php endif; ?>
                </div>

                <div class="col-md-5 col-sm-6 halim-search-form hidden-xs">
                    <div class="header-nav">
                        <div class="col-xs-12">
                            <form id="search-form-pc" name="halimForm" role="search" action="<?php echo esc_url(home_url('/')); ?>" method="GET">
                                <div class="form-group">
                                    <div class="input-group col-xs-12">
                                        <input id="search" type="text" name="s" value="<?php echo get_search_query(); ?>" class="form-control" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php _e('Press Enter to search', 'halimthemes'); ?>" placeholder="<?php printf(  __( ' %s movie...', 'halimthemes' ), $postCount ); ?>" autocomplete="off" required>
                                        <i class="animate-spin hl-spin4 hidden"></i>
                                    </div>
                                </div>
                            </form>
                            <ul class="ui-autocomplete ajax-results hidden"></ul>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-4 hidden-xs">
                    <div id="get-bookmark" class="box-shadow"><i class="hl-bookmark"></i><span> <?php _e('Bookmarks', 'halimthemes'); ?></span><span class="count">0</span></div>
                     
                    <?php
                        $enable_user_login_register = cs_get_option('enable_user_login_register');
                        if($enable_user_login_register || is_user_logged_in()) HaLimCore::halim_userAccess();
                        
                    ?>
                    <div id="bookmark-list" class="hidden bookmark-list-on-pc"><ul style="margin: 0;"></ul></div>
                </div> -->
                <!-- <div class="mobile-icon-menu"> -->
                <div class="col-md-4 col-sm-12 menu-right">
                    <div class="nav-items flex-wrap flex">
                        <a href="/history" title="Lịch sử xem">
                            <div>
                            <i class="hl-clock"></i>
                            </div>
                        </a>
                        <a href="/bookmark" title="Bookmark" class="get-bookmark-on-mobile">
                            <div>
                            <i class="hl-bookmark"></i>
                            </div>
                        </a>
                        <div class="nav-menu-user">
                        <?php if ( is_user_logged_in() ) : ?>
    <!-- Nội dung khi user đã đăng nhập -->
    <a href="<?php echo wp_logout_url(home_url()); ?>">
<?php else : ?>
    <!-- Nội dung khi user chưa đăng nhập -->
    <a href="javascript:void(0);" onclick="openLoginModal();">
<?php endif; ?>
                            <i class="hl-user"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>
    <div class="navbar-container">
        <div class="container">
            <nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="<?php echo cs_get_option('hover_dropdown_menu'); ?>">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#halim" aria-expanded="false">
                        <span class="sr-only"><?php _e('Menu', 'halimthemes') ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#user-info" aria-expanded="false">
                        <span class="hl-dot-3 rotate" aria-hidden="true"></span>
                    </button> -->
                    <button type="button" class="navbar-toggle collapsed pull-right expand-search-form" data-toggle="collapse" data-target="#search-form" aria-expanded="false">
                        <span class="hl-search" aria-hidden="true"></span>
                    </button>
                    <!-- <button type="button" class="navbar-toggle collapsed pull-right get-bookmark-on-mobile">
                        <i class="hl-bookmark" aria-hidden="true"></i>
                        <span class="count">0</span>
                    </button> -->
                </div>
                <div class="collapse navbar-collapse" id="halim">
                    <?php
                        wp_nav_menu( array(
                            'depth'             => 2,
                            'theme_location'    => 'header_menu',
                            'menu_class'        => 'nav navbar-nav navbar-left',
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker())
                        );
                    ?>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div class="collapse navbar-collapse" id="search-form">
                <div id="mobile-search-form" class="halim-search-form"></div>
            </div>
            <div class="collapse navbar-collapse" id="user-info">
                <div id="mobile-user-login"></div>
            </div>
        </div>
    </div>
<!-- /header -->
<div class="container">
    <?php if(cs_get_option('enable_header_banner_ads')) : ?>
    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
        <?php echo cs_get_option('header_banner_ads'); ?>
    </div>
    <?php endif; ?>
    <div class="row fullwith-slider">
        <?php if(is_home()) dynamic_sidebar('bs-slider') ?>
    </div>
</div>
<div class="container-fluid halim-full-player hidden halim-centered">
    <div id="halim-full-player" class="container col-md-offset-2s col-md-8"></div>
</div>
<div class="container">
    <div class="row container" id="wrapper">
        <?php get_template_part('templates/search-filter'); ?>
        <?php if(cs_get_option('alphabet_filter')) get_template_part('templates/letter.tpl'); ?>