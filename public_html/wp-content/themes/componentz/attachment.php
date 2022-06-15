<?php
/**
 * The template for displaying attachment file
 *
 * @link https://developer.wordpress.org/themes/template-files-section/attachment-template-files/
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

<section id="primary" class="<?php Componentz()->get->primary_class(); ?>">
    <?php
    /**
     * Hook: componentz/theme/before_article_wrapper
     *
     * @hooked componentz_grid_item_start - 10
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/before_article_wrapper' ); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content"><?php
            $image_size = apply_filters( 'wporg_attachment_size', 'medium' ); 
            echo wp_get_attachment_image( get_the_ID(), $image_size ); ?>
        </div>
    </article><?php
    
    /**
     * Hook: componentz/theme/after_article_wrapper
     *
     * @hooked componentz_grid_item_end - 10
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/after_article_wrapper' ); ?>
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

get_sidebar();

get_footer(); ?>
