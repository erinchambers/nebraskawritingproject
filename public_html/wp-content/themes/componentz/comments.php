<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

namespace Componentz;

// Do not allow direct access.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
    return;
}

if ( comments_open() ) {
    $wrapper_class = 'comments-area';
} else {
    $wrapper_class = 'comments-area comments-closed';
}

$discussion = componentz_get_discussion_data();

if ( $discussion->responses > 0 ) {
    $subwrapper_class = 'comments-title-wrap';
} else {
    $subwrapper_class = 'comments-title-wrap no-responses';
}
?>

<div id="comments" class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="<?php echo esc_attr( $subwrapper_class ); ?>">
        <?php if( have_comments() ): ?>
            <h2 class="comments-title">
                <?php
                if ( comments_open() ) {
                    if ( have_comments() ) {
                        comments_number(
                            '',
                            esc_html__( '1 Comment', 'componentz' ),
                            esc_html__( '% Comments', 'componentz' )
                        );
                    }
                } else {
                    comments_number(
                        '',
                        esc_html__( '1 Comment', 'componentz' ),
                        esc_html__( '% Comments', 'componentz' )
                    );
                }
                ?>
            </h2><!-- .comments-title -->
        <?php endif; ?>
        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() ) : ?>
            <p class="no-comments">
                <?php _e( 'Comments are closed', 'componentz' ); ?>
            </p>
        <?php
        endif; ?>
    </div><!-- .comments-title-flex -->
    <?php
    if ( have_comments() ) :

        // Show comment form at top if showing newest comments at the top.
        if ( comments_open() ) {
            componentz_comment_form( true );
        }

        ?>
        <ul class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'walker'      => new WalkerComment(),
                    'avatar_size' => componentz_get_avatar_size(),
                    'short_ping'  => true,
                    'style'       => 'ol',
                    'type'        => 'comment'
                )
            );
            ?>
        </ul><!-- .comment-list -->
        <ul class="pingback-list">
            <?php
            wp_list_comments(
                array(
                    'walker'      => new WalkerComment(),
                    'avatar_size' => componentz_get_avatar_size(),
                    'short_ping'  => true,
                    'style'       => 'ol',
                    'type'        => 'pings'
                )
            );
            ?>
        </ul><!-- .pingback-list -->

        <?php if( have_comments() ): ?>
        <nav class="navigation cz-pagination" role="navigation">
            <div class="nav-links">
                <?php

                if ( is_rtl() ) {
                    $prev_icon = Componentz()->svg->icon('cz-icon-arrow-right');
                    $next_icon = Componentz()->svg->icon('cz-icon-arrow-left');
                } else {
                    $prev_icon = Componentz()->svg->icon('cz-icon-arrow-left');
                    $next_icon = Componentz()->svg->icon('cz-icon-arrow-right');
                }

                paginate_comments_links([
                    'prev_text' => $prev_icon . '<span class="screen-reader-text">' . __( 'Previous Comments', 'componentz' ) . '</span>',
                    'next_text' => $next_icon . '<span class="screen-reader-text">' . __( 'Next Comments', 'componentz' ) . '</span>'
                ]);
                ?>
            </div>
        </nav>
    <?php
    endif;

    else :

        // Show comment form.
        componentz_comment_form( true );

    endif; // if have_comments();
    ?>
</div>
