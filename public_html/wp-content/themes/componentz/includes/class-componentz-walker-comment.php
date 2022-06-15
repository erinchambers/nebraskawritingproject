<?php
/**
 * Walker Comment
 *
 * Custom comment walker for Componentz theme.
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

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 1.0.0
 */
class WalkerComment extends \Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int $depth Depth of the current comment.
	 * @param array $args An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		?>
        <<?php echo $tag; ?> id="comment-<?php echo esc_attr( get_comment_ID() ); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
        <article id="div-comment-<?php echo esc_attr( get_comment_ID() ); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard cz-d-block cz-d-sm-flex cz-align-items-center">
					<?php
					$comment_author_link = get_comment_author_link( $comment );
					$comment_author_url  = get_comment_author_url( $comment );
					$comment_author      = get_comment_author( $comment );
					$avatar              = get_avatar( $comment, $args['avatar_size'] );
                    $allowed_html        = [
                        'img' => [
                            'src' => [],
                            'alt' => [],
                            'class' => [],
                            'height' => [],
                            'width' => []
                        ]
                    ];
					if ( 0 != $args['avatar_size'] ) {
						if ( empty( $comment_author_url ) ) {
							echo wp_kses( $avatar, $allowed_html );
						} else {
							printf( '<a class="avatar url" title="%1$s" href="%2$s" rel="external nofollow">', esc_html( $comment_author ), esc_url( $comment_author_url ) );
							echo wp_kses( $avatar, $allowed_html );
						}
					}

					printf(
					/* translators: %s: comment author link */
						wp_kses(
							'%s <span class="screen-reader-text says">'. esc_html__( 'says:', 'componentz' ) .'</span>',
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						'<b class="fn">' . get_comment_author_link( $comment ) . '</b>'
					);

					if ( ! empty( $comment_author_url ) ) {
						echo '</a>';
					}
					?>
                    <span class="dot cz-mx-2"></span>
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<?php
						/* translators: 1: comment date, 2: comment time */
						$comment_timestamp = sprintf( '%1$s', get_comment_date( '', $comment ) );
						?>
                        <time datetime="<?php comment_time( 'c' ); ?>" title="<?php echo esc_attr( $comment_timestamp ); ?>">
							<?php echo esc_html( $comment_timestamp ); ?>
                        </time>
                    </a>
                </div><!-- .comment-author -->
				<?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation">
                        <?php esc_html_e( 'Your comment is awaiting moderation', 'componentz' ); ?>
                    </p>
				<?php endif; ?>
            </footer><!-- .comment-meta -->

            <div class="comment-content">
				<?php
				$edit_comment_icon = Componentz()->svg->icon( 'cz-icon-pencil' );
				edit_comment_link( $edit_comment_icon . esc_html__( 'Edit', 'componentz' ), '<span class="edit-link">', '</span>' );
				?>
				<?php comment_text(); ?>
            </div><!-- .comment-content -->

        </article><!-- .comment-body -->

		<?php
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below'  => 'div-comment',
					'depth'      => $depth,
					'max_depth'  => $args['max_depth'],
					'reply_text' => Componentz()->svg->icon( 'cz-icon-reply' ) . esc_html__( 'Reply', 'componentz' ),
					'before'     => '<div class="comment-reply">',
					'after'      => '</div>',
				)
			)
		);
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
