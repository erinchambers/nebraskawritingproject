<?php
/**
 * Post Meta
 *
 * Componentz class to display post meta details.
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

class Post_Meta {

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
	 * Author
	 *
	 * Display post author.
	 *
	 * @param string $template (optional) The template name where we want display author meta.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function author( $template = null ) {
		global $post;

		$author_id = esc_attr( get_the_author_meta( 'ID' ) );

		if ( 'header' == $template ) {
			$author_id = esc_attr( $post->post_author );
		}

		$meta = sprintf(
		/* translators: 1: post author, only visible to screen readers. 2: author link. */
			'<span class="byline"><span class="screen-reader-text">%1$s</span>' .
			'<span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span><span class="dot cz-mx-2"></span></span>',
			esc_html__( 'Posted by', 'componentz' ),
			esc_url( get_author_posts_url( $author_id ) ),
			esc_html( ucfirst( get_the_author_meta( 'display_name', $author_id ) ) )
		);

		return ! empty( $meta ) ? $meta : '';
	}

	/**
	 * Categories
	 *
	 * Display post categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function categories() {
		$categories_list = get_the_category_list( '<span class="dot cz-mx-2"></span>' );
		if ( $categories_list ) {
			$meta = sprintf(
                /* translators: 
                 * 1: posted in label, only visible to screen readers. 
                 * 2: list of categories. 
                 */
				'<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
				esc_html__( 'Posted in', 'componentz' ),
				Componentz()->helper->escape_categories_list( $categories_list )
			); // phpcs:ignore
		}

		return ! empty( $meta ) ? $meta : '';
	}

	/**
	 * Comments Count
	 *
	 * Display post comment count.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function comments() {
        if( is_attachment() ) {
            $meta  = '<span>';
            $meta .= esc_html__( 'Published in', 'componentz' ) .' ';
            $meta .= $attachment_title = esc_html( get_the_title( get_the_ID() ) );
            $meta .= '</span><span class="dot cz-mx-2"></span>';
        } else {
            if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                ob_start();

                /* translators: %s: Name of current post. Only visible to screen readers. */
                comments_popup_link(
                    sprintf(
                        '%s<span class="screen-reader-text"> %s %s</span>',
                        esc_html__( 'Leave a comment', 'componentz' ),
                        esc_html__( 'on', 'componentz' ),
                        esc_html( get_the_title() )
                    )
                );

                $comments_popup_link = ob_get_contents();

                ob_end_clean();

                $meta = '<span class="comments-link">' . $comments_popup_link . '</span>';
            }
        }

		return ! empty( $meta ) ? $meta : '';
	}

	/**
	 * Date
	 *
	 * Display post publish date.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function date() {
        global $post;
        
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>' .
			               '<time class="updated cz-d-none" datetime="%3$s">%4$s</time>';
		}
        
        // If we are on bbPress pages.
        if( Componentz()->helper->is_bbpress() ) {
            $date_format = esc_attr( get_option( 'date_format' ) );
            $post_date = '';
            $post_modified = '';
            
            if( is_object( $post ) ) {
                if( ! $post->post_date ) {
                    $post_date = esc_html( date( $date_format, strtotime( $post->post_date_gmt ) ) );
                } else {
                    $post_date = esc_html( date( $date_format, strtotime( $post->post_date ) ) );
                }
                if( ! $post->post_modified ) {
                    $post_modified = esc_html( date( $date_format, strtotime( $post->post_modified_gmt ) ) );
                } else {
                    $post_modified = esc_html( date( $date_format, strtotime( $post->post_modified ) ) );
                }
            }
            
            $time_string = sprintf(
                $time_string,
                $post_date,
                $post_date,
                $post_modified,
                $post_modified
            );
        } else {
            $time_string = sprintf(
                $time_string,
                esc_attr( get_the_date( DATE_W3C ) ),
                esc_html( get_the_date() ),
                esc_attr( get_the_modified_date( DATE_W3C ) ),
                esc_html( get_the_modified_date() )
            );
        }
        
        if( is_single() && ! Componentz()->helper->is_bbpress() ) {
            $permalink = get_month_link( 
                esc_html( get_the_date('Y') ), 
                esc_html( get_the_date('m') ) 
            );
        } else {
            $permalink = get_permalink();
        }
        
		$meta = sprintf(
			'<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( $permalink ),
			$time_string
		);

		return ! empty( $meta ) ? $meta : '';
	}

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
