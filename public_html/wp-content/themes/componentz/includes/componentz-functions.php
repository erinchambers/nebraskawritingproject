<?php
/**
 * Componentz Functions
 *
 * The main file holding all Componentz theme functions.
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

if ( ! function_exists( 'wp_body_open' ) ) {
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support WordPress versions prior to 5.2.0.
     *
     * @since 1.0.3
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action( 'wp_body_open' );
    }
}

/**
 * Header Styles
 *
 * The main componentz function which holds all header styles.
 *
 * @used in componentz-actions.php
 * @used in class-componentz-choices.php
 *
 * @since 1.0.0
 * @return array
 */
function componentz_header_styles() {
    $default['v1'] = [
        'name' => __( 'Header V1', 'componentz' ),
        'filename' => 'header-v1.php',
        'path' => get_template_directory() . '/template-parts/header/'
    ];

    /**
     * Filters the list of headers.
     *
     * @param array $default (required) The list of default theme headers.
     *
     * @since 1.0.0
     */
    $headers = apply_filters( 'componentz/theme/headers', $default );

    // Sanitize array list.
    if( is_array( $headers ) ) {
        foreach( $headers as $key => $value ) {
            $array[$key] = [
                'name' => isset( $value['name'] ) ? esc_html( $value['name'] ) : esc_html__( 'Unknown', 'componentz' ),
                'filename' => isset( $value['filename'] ) ? esc_attr( $value['filename'] ) : '',
                'path' => isset( $value['path'] ) ? wp_normalize_path( $value['path'] ) : ''
            ];
        }
    }

    // Ascending order.
    asort( $array );

    return $array;
}

/**
 * Icon
 *
 * Generates SVG icon on request.
 *
 * @param string $icon    (required) The name of the icon.
 * @param bool   $backend (optional) Load backend icons if isset "true".
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_svg( $icon, $backend = false ) {
    if( empty( $icon ) ) {
        return;
    }

    if( $backend ) {
        $svg  = '<svg class="cz-icon '. esc_attr( $icon ) .'" aria-hidden="true" role="img">';
        $svg .= '<use xlink:href="'. get_template_directory_uri() . '/assets/img/icons/admin.svg#' . esc_html( $icon ) .'"></use>';
        $svg .= '</svg>';
    } else {
        $svg  = '<svg class="cz-icon '. esc_attr( $icon ) .'" aria-hidden="true" role="img">';
        $svg .= '<use xlink:href="'. get_template_directory_uri() . '/assets/img/icons/front.svg#' . esc_html( $icon ) .'"></use>';
        $svg .= '</svg>';
    }

    return $svg;
}

/**
 * Is Comment by Post Author
 *
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 * @since 1.0.0
 * @return bool
 */
function componentz_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * Get Discussion Data
 *
 * Returns information about the current post's discussion, with cache support.
 *
 * @since 1.0.0
 * @return object
 */
function componentz_get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		[
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => esc_attr( get_option( 'comment_order', 'asc' ) ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		]
	);

	$authors = [];
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) [
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	];

	return $discussion;
}

/**
 * Avatar Size
 *
 * Returns the size for avatars used in the theme.
 *
 * @since 1.0.0
 * @return int
 */
function componentz_get_avatar_size() {
	return 70;
}

/**
 * Comment Avatar
 *
 * Returns the HTML markup to generate a user avatar.
 *
 * @since 1.0.0
 * @return mixed
 */
if ( ! function_exists( 'componentz_comment_avatar' ) ) :
	function componentz_get_user_avatar_markup( $id_or_email = null ) {
		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( 
            '<div class="comment-user-avatar comment-author vcard">%s</div>', 
            get_avatar( $id_or_email, componentz_get_avatar_size() ) 
        );
	}
endif;

/**
 * Discussion Avatar List
 *
 * Displays a list of avatars involved in a discussion for a given post.
 *
 * @since 1.0.0
 * @return mixed
 */
if ( ! function_exists( 'componentz_discussion_avatars_list' ) ) :
	function componentz_discussion_avatars_list( $comment_authors ) {
		if ( empty( $comment_authors ) ) {
			return;
		}
		echo '<ol class="discussion-avatar-list">', "\n";
		foreach ( $comment_authors as $id_or_email ) {
			printf(
				"<li>%s</li>\n",
				componentz_get_user_avatar_markup( $id_or_email ) // phpcs:ignore
			);
		}
		echo '</ol><!-- .discussion-avatar-list -->', "\n";
	}
endif;

/**
 * Comment Form
 *
 * Display comment form.
 *
 * @since 1.0.0
 * @return mixed
 */
if ( ! function_exists( 'componentz_comment_form' ) ) :
	function componentz_comment_form( $order ) {
		if ( true === $order || 
             strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) 
           ) 
        {
			comment_form(
				[
					'logged_in_as' => null,
					'title_reply'  => null,
				]
			);
		}
	}
endif;

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
