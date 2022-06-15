<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
    if ( have_posts() ) {
        
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
            get_template_part( 'template-parts/content/content' );
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

    } else {

        // If no content, include the "No posts found" template.
        get_template_part( 'template-parts/content/content', 'none' );
        
    } 
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
