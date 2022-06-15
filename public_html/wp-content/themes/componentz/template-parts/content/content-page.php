<?php
/**
 * Content Page
 *
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

/**
 * Hook: componentz/theme/before_article_wrapper
 *
 * @hooked grid_item_start - 10
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/before_article_wrapper' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'componentz' ),
				'after'  => '</div>',
			)
		);
		?>
    </div>
</article>

<?php
/**
 * Hook: componentz/theme/after_article_wrapper
 *
 * @hooked grid_item_end - 10
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_article_wrapper' ); ?>
