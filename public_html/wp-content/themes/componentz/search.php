<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
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
    if ( have_posts() ) :
    
        /**
         * Hook: componentz/theme/before_posts_loop
         *
         * @hooked componentz_primary_sub_wrapper_start - 10
         * @hooked componentz_grid_container_start - 20
         *
         * @since 1.0.0
         */
        do_action( 'componentz/theme/before_posts_loop' );

        // Start the Loop.
        while ( have_posts() ) :
            the_post();

            /*
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part( 'template-parts/content/content', 'excerpt' );

            // End the loop.
        endwhile;
    
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

    // If no content, include the "No posts found" template.
    else :

        get_template_part( 'template-parts/content/content', 'none' );

    endif; ?>
</section><!-- #primary -->

<?php
/**
 * Hook: componentz/theme/after_primary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_primary_wrapper' );

get_footer();