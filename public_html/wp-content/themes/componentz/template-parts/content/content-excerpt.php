<?php
/**
 * Content Excerpt
 *
 * Template part for displaying post archives and search results
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

global $post;

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
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( 
                '<span class="sticky-post">%s</span>', 
                esc_html_x( 'Featured', 'post', 'componentz' ) 
            );
		}
        
		the_title( 
            sprintf( 
                '<h2 class="entry-title"><a href="%s" rel="bookmark">', 
                esc_url( get_permalink() ) 
            ), 
            '</a></h2>' 
        ); ?>
	</header>
    
    <?php if( is_search() && 'page' !== $post->post_type || is_archive() ) Componentz()->blog->post_meta(); ?>

	<?php Componentz()->blog->thumbnail(); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
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
