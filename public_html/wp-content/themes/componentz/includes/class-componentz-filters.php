<?php
/**
 * Componentz Filters
 *
 * WordPress offers filter hooks to allow plugins to modify various types of internal data at runtime.
 *
 * A plugin can modify data by binding a callback to a filter hook. When the filter is later applied,
 * each bound callback is run in order of priority, and given the opportunity to modify a value by returning a new value.
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

class Filters {

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
	 * Class Constructor
	 */
	public function __construct() {
        
        add_filter( 'componentz/theme/custom_fonts', [ 'Componentz\Admin\Choices', 'custom_fonts' ] );
		add_filter( 'clean_url', [ $this, 'defer_parsing_of_js' ], 11, 1 );
		add_filter( 'body_class', [ $this, 'body_class' ] );
		add_filter( 'post_class', [ $this, 'post_class' ] );
		add_filter( 'comment_form_defaults', [ $this, 'comment_form_defaults' ] );
		add_filter( 'comment_form_default_fields', [ $this, 'comment_form_default_fields' ] );
		add_filter( 'excerpt_more', [ $this,'custom_excerpt_more'] );

	}
    
    

	/**
	 * Defer Javascript
	 *
	 * Defer parsing of Javascript.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function defer_parsing_of_js( $url ) {
		if ( strpos( $url, '#asyncload' ) === false ) {
			return $url;
		} else if ( is_admin() ) {
			return str_replace( '#asyncload', '', $url );
		} else {
			return str_replace( '#asyncload', '', $url ) . "' async='async";
		}
	}

	/**
	 * Body Class
	 *
	 * Displays the class names for the body element.
	 *
	 * @param array $classes (optional) Space-separated array of class names to add to the class list.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function body_class( $classes ) {
        $content_layout = get_theme_mod( 'componentz_content_layout', 'eight-three' );
        $content_layout = esc_attr( $content_layout );
        
        // Sidebar is empty.
        if ( ! is_active_sidebar( 'componentz-sidebar' ) ) {
            $classes[] = 'no-sidebar';
        }
        
        // If layout style is set to wide-width.
        if( 'twelve' == $content_layout ) {
            $classes[] = 'no-sidebar';
        }
        
        // Is customize preview.
        if( is_customize_preview() ) {
            $classes[] = 'is-customize-preview';
        }

		return $classes;
    }

	/**
	 * Post Class
	 *
	 * Filter post_class for particular archive pages.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function post_class( $classes ) {
		if ( is_archive() || is_search() ) {
			$classes[] = 'grid-style';
		}

		return $classes;
	}

	/**
	 * Comment Form Defaults
	 *
	 * Filters the comment form default arguments.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function comment_form_defaults( $defaults ) {
		$comment_field = $defaults['comment_field'];

		$defaults['comment_notes_before'] = '';
		$defaults['comment_field']        = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );
		$defaults['label_submit']         = esc_html__( 'Add your comment', 'componentz' );
		$defaults['comment_field']        = str_replace( 'comment-form-comment', 'comment-form-comment form-group', $defaults['comment_field'] );
		$defaults['comment_field']        = str_replace( '<textarea', '<textarea placeholder="' . esc_attr__( 'Add comment', 'componentz' ) . '" ', $defaults['comment_field'] );
		$defaults['comment_field']        = str_replace( '<textarea', '<textarea class="cz-form-control" ', $defaults['comment_field'] );

		return $defaults;
	}

	/**
	 * Comment Form Default Fields
	 *
	 * Filters the default comment form fields.
	 *
	 * @since 1.0.0
	 * @access pubic
	 * @return array
	 */
	public function comment_form_default_fields( $fields ) {
		$fields['author'] = str_replace( 'comment-form-author', 'comment-form-author cz-form-group', $fields['author'] );
		$fields['author'] = str_replace( '<input', '<input class="cz-form-control" ', $fields['author'] );
		$fields['email']  = str_replace( 'comment-form-email', 'comment-form-email cz-form-group', $fields['email'] );
		$fields['email']  = str_replace( '<input', '<input class="cz-form-control" ', $fields['email'] );
		$fields['url']    = str_replace( 'comment-form-url', 'comment-form-url cz-form-group', $fields['url'] );
		$fields['url']    = str_replace( '<input', '<input class="cz-form-control" ', $fields['url'] );

		unset( $fields['cookies'] );

		return $fields;
	}

	/**
	 * Custom Excerpt More
	 *
	 * Filter the excerpt "read more" string.
	 *
	 * @since 1.0.0
	 * @param string $more "Read more" excerpt string.
	 * @return string (Maybe) modified "read more" excerpt string.
	 */
	public function custom_excerpt_more( $more ) {
		$more = '&hellip;';

		return $more;
	}

}

Filters::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
