<?php
/**
 * Content Single
 *
 * Template part for displaying single posts
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
		the_content(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'componentz' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'componentz' ),
				'after'  => '</div>',
			)
		);
		?>
    </div>

    <footer class="entry-footer">
		<?php Componentz()->blog->entry_footer(); ?>
    </footer>
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
