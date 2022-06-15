<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
    
    /**
     * Hook: componentz/theme/before_posts_loop
     *
     * @hooked componentz_primary_sub_wrapper_start - 10
     * @hooked componentz_grid_container_start - 20
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/before_posts_loop' );
    
	/* Start the Loop */
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content/content', 'single' );

		if ( is_singular( 'attachment' ) ) {
			// Parent post navigation.
			the_post_navigation(
				array(
                    /* translators: %s: parent post link */
                    'prev_text' => sprintf( 
                        '<span class="meta-nav">%s</span><span class="post-title">%s</span>', 
                        __( 'Published in', 'componentz' ),
                        '%title' 
                    )
				)
			);
		} elseif ( is_singular( 'post' ) ) {
			// Previous/next post navigation.

            if ( is_rtl() ) {
                $next_icon = Componentz()->svg->icon('cz-icon-arrow-left');
                $prev_icon = Componentz()->svg->icon('cz-icon-arrow-right');
            } else {
                $next_icon = Componentz()->svg->icon('cz-icon-arrow-right');
                $prev_icon = Componentz()->svg->icon('cz-icon-arrow-left');
            }

			the_post_navigation(
				[
					'next_text' => '<span class="cz-d-inline-flex cz-align-items-center meta-nav" aria-hidden="true">' . esc_html__( 'Next Post', 'componentz' ) . $next_icon . '</span> ' .
					               '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'componentz' ) . '</span> <br/>' .
					               '<span class="post-title">%title</span>',
					'prev_text' => '<span class="cz-d-inline-flex cz-align-items-center meta-nav" aria-hidden="true">' . $prev_icon . esc_html__( 'Previous Post', 'componentz' ) . '</span> ' .
					               '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'componentz' ) . '</span> <br/>' .
					               '<span class="post-title">%title</span>',
				]
			);
		}
    
        // If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
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

	endwhile; // End of the loop. 
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
