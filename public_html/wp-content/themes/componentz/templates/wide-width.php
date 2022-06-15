<?php
/**
 * Template Name: Wide Width
 *
 * componentz wide width template without sidebar.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
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

<section id="primary" class="cz-col-12"><?php
    /**
     * Hook: componentz/theme/before_posts_loop
     *
     * @hooked primary_sub_wrapper_start - 10
     * @hooked grid_container_start - 10
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/before_posts_loop' );
    
    /* Start the Loop */
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content/content', 'page' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

    endwhile; // End of the loop.
    
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
    do_action( 'componentz/theme/after_posts_loop' ); ?>
</section>

<?php
/**
 * Hook: componentz/theme/after_primary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_primary_wrapper' );

get_footer(); ?>
