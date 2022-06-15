<?php
/**
 * Content
 *
 * Template part for displaying posts
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

    <header class="entry-header">
		<?php

		$format = get_post_format() ?: 'standard';

		if ( $format != 'standard' ) {
			$format = Componentz()->svg->icon( 'cz-icon-' . $format );
		} else {
			$format = '';
		}
        
		if ( is_sticky() ) {
			printf( '<span class="sticky-post page-sub">%1$s%2$s</span>', esc_html_x( 'Featured', 'post', 'componentz' ), $format ); // phpcs:ignore
		} elseif ( $format ) {
			printf( '<span class="format-post page-sub">%s</span>', $format ); // phpcs:ignore
		}
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>
        
        <?php Componentz()->blog->post_meta(); ?>
        
		<?php if ( get_edit_post_link() ) : ?>
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
				        '%1$s '. esc_html__( 'Edit', 'componentz' ) . '<span class="screen-reader-text">%2$s</span>',
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					Componentz()->svg->icon( 'cz-icon-pencil' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		<?php endif; ?>
    </header>

	<?php Componentz()->blog->thumbnail(); ?>

    <div class="entry-content">
		<?php
		the_excerpt(
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
