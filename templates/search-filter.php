<?php
/**
 *  Filter tpl
 */
?>
<div class="halim-panel-filter">
    <div class="panel-heading">
        <div class="row">
            <div class="<?php echo cs_get_option('disable_filter_movie') == true ? 'col-xs-12' : 'col-xs-8'; ?> hidden-xs">
                <?php
					if(is_home()) {
						bloginfo( 'name' );
					} else {
                        if(function_exists('yoast_breadcrumb')) {
                            yoast_breadcrumb('<div class="yoast_breadcrumb">','</div>');
                        } elseif(function_exists("seopress_display_breadcrumbs")) {
                            seopress_display_breadcrumbs();
                        } elseif(function_exists('rank_math_the_breadcrumbs')) {
                            rank_math_the_breadcrumbs();
                        }
                        else {
                            // custom breadcrumb
                        }
					}
				?>
            </div>
            <?php if(cs_get_option('disable_filter_movie') !== true) : ?>
            <div class="col-xs-4 text-right">
                <a href="javascript:;" id="expand-ajax-filter"><?php _e('Filter movies', 'halimthemes') ?> <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
            </div>
        <?php endif; ?>
        <div id="alphabet-filter" style="float: right;display: inline-block;margin-right: 25px;"></div>
        </div>
    </div>
	<div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
        <div class="ajax"></div>
    </div>
</div><!-- end panel-default -->

