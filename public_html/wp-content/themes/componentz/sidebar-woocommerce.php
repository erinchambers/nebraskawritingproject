<?php
/**
 * Sidebar WooCommerce
 *
 * The WooCommerce sidebar containing shop widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.1
 */

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If shop sidebar is not active let's return early.
if ( ! is_active_sidebar( 'componentz-woocommerce-sidebar' ) ) {
	return;
}

// If layout style is set to wide-width let's return early.
if( 'twelve' == Componentz()->get->content_layout() && ! is_customize_preview() ) {
    return;
}

/**
 * Hook: componentz/theme/before_secondary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/before_secondary_wrapper' ); ?>

<aside id="secondary" class="<?php Componentz()->get->sidebar_class(); ?>" role="complementary">
    <?php
    /**
     * Hook: componentz/theme/before_sidebar_widgets
     *
     * @hooked componentz_secondary_sub_wrapper_start - 10
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/before_sidebar_widgets' ); ?>
    
    <?php dynamic_sidebar( 'componentz-woocommerce-sidebar' ); ?>
    
    <?php
    /**
     * Hook: componentz/theme/after_sidebar_widgets
     *
     * @hooked componentz_secondary_sub_wrapper_end - 10
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/after_sidebar_widgets' ); ?>
</aside><!-- #secondary -->

<?php
/**
 * Hook: componentz/theme/after_secondary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_secondary_wrapper' ); ?>
