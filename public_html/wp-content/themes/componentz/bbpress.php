<?php
/**
 * The main bbPress template file
 *
 * Wraps bbPress forums with Componentz wrappers.
 *
 * @link https://codex.bbpress.org/themes/theme-compatibility/getting-started-in-modifying-the-main-bbpress-template/
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

// Do not allow direct access.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} 

get_header();

/**
 * Hook: componentz/theme/before_primary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/before_primary_wrapper' ); ?>

<section id="primary" class="<?php Componentz()->get->primary_class(); ?>"><?php
    
    /**
     * Hook: componentz/theme/before_posts_loop
     *
     * @hooked componentz_primary_sub_wrapper_start - 10
     * @hooked componentz_grid_container_start - 20
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/before_posts_loop' );
    
    // Load posts loop.
    while ( have_posts() ) {
        the_post();
        the_content();
    }
    
    /**
     * Hook: componentz/theme/after_posts_loop
     *
     * @hooked componentz_grid_container_end - 10
     * @hooked componentz_pagination - 20
     * @hooked componentz_sidebar_toggler - 30
     * @hooked componentz_primary_sub_wrapper_end - 40
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/after_posts_loop' );

?></section>

<?php
/**
 * Hook: componentz/theme/after_primary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_primary_wrapper' ); 

get_sidebar();

get_footer(); ?>
