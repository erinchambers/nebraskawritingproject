<?php
/**
 * Blog Class
 *
 * Componentz blog related class.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

namespace Componentz;

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blog {

	/**
	 * Instance
	 *
	 * Single instance of this object.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * Get Instance
	 *
	 * Access the single instance of this class.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Posts Thumbnail
	 *
	 * Display posts featured image.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function thumbnail( $data = null ) {
		if ( has_post_thumbnail() ) {
            
            // Not a single post or page.
            if( ! is_single() && ! is_page() ) {
                echo '<a title="'. get_the_title() .'" href="'. esc_url( get_permalink() ) .'">';
            }
            
            // Is home, archive or search page.
            if( is_home() || is_archive() || is_search() ) {
                echo '<div class="featured-image-wrapper">';
            }
            
            // Display post thumbnail.
            the_post_thumbnail( 'full', [ 'class' => 'post-featured-image' ] );
            
            // Is home, archive or search page.
            if( is_home() || is_archive() || is_search() ) {
                echo '</div>';   
            }
            
            // Not a single post or page.
            if( ! is_single() && ! is_page() ) {
                echo '</a>';
            }
		}
	}

	/**
	 * Post Meta
	 *
	 * Retrieve a post meta details for a post.
	 *
	 * @param string $template (optional) The template name where we want display post meta.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function post_meta( $template = null ) {
		global $post;
        
        /**
         * The categories post meta type won't be shown in header jumbotron area,
         * since the header jumbotron have own customized categories post meta.
         */
		if ( 'header' !== $template ) {
			$meta_type['categories'] = Componentz()->meta->categories();
		}
        
        /**
         * The componentz default meta types.
         * Displays both in header jumbotron and post content.
         */
		$meta_type['comments'] = Componentz()->meta->comments();
		$meta_type['author']   = Componentz()->meta->author( $template );
		$meta_type['date']     = Componentz()->meta->date();
        
        /**
         * Filters the list of meta types.
         *
         * @param array $meta_type (required) The list of meta types we want display.
         *
         * @since 1.0.0
         */
		$meta_types = apply_filters( 'componentz/theme/post_meta', $meta_type ); // phpcs:ignore
        
        /**
         * Every $meta_type ID must be unique,
         * there are no 2 identical meta types.
         */
        if( is_array( $meta_type ) ) {
            $meta_type = array_unique( $meta_type );
        }
        
        /**
         * Display post meta in header jumbotron or post content.
         */ ?>
        <ul class="cz-d-block post-meta"><?php
            if ( $meta_types && is_array( $meta_types ) ) :
               foreach ( $meta_types as $meta ) : ?>
                <li><?php Componentz()->helper->escape_post_meta( $meta ); // phpcs:ignore ?></li>
                <?php
               endforeach; 
            endif; ?>
        </ul><!-- .post-meta -->
        <?php
	}

	/**
	 * Post Tags
	 *
	 * Retrieve the tags for a post.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function tags() {
		if ( has_tag() ) {
			the_tags( 
                '<h3 class="tags-title">' . 
                esc_html__( 'Explore post tags', 'componentz' ) . 
                '</h3><div class="post-tags">', '', '</div>' 
            );
		}
	}

	/**
	 * Pagination
	 *
	 * Retrieves a paginated navigation to next/previous set of posts, when applicable.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function pagination() {

        if ( is_rtl() ) {
            $prev_icon = Componentz()->svg->icon('cz-icon-arrow-right');
            $next_icon = Componentz()->svg->icon('cz-icon-arrow-left');
        } else {
            $prev_icon = Componentz()->svg->icon('cz-icon-arrow-left');
            $next_icon = Componentz()->svg->icon('cz-icon-arrow-right');
        }

		$pagination = get_the_posts_pagination(
			[
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s',
                    $prev_icon . '<span class="screen-reader-text">' . __( 'Previous Posts', 'componentz' ) . '</span>'
				),
				'next_text' => sprintf(
					'%s',
                    $next_icon . '<span class="screen-reader-text">' . __( 'Next Posts', 'componentz' ) . '</span>'
				),
			]
		);
        
        if( ! empty( $pagination ) ) {
            $pagination = str_replace( 'pagination', 'cz-pagination', $pagination );
            Componentz()->helper->escape_pagination( $pagination ); // phpcs:ignore
        }
	}

	/**
	 * Entry Footer
	 *
	 * Display posts entry footer content.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function entry_footer() {
		if ( is_single() ) {
			$this->tags();
		}
	}

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
