<?php
/**
 * Content None
 *
 * Template part for displaying a message that posts cannot be found
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
} ?>

<section class="no-results not-found">
    <div class="page-content">
		<?php
		if ( is_home() ) :

            $count_posts = wp_count_posts();

            if ( current_user_can( 'publish_posts' ) ) :

                if( $count_posts->publish == 1 ) {
                    $translate = esc_html__( 'Ready to publish your second post?', 'componentz' ) .' <a href="%1$s">' . esc_html__( 'Get started here', 'componentz' ) .'</a>';
                } else {
                    $translate = esc_html__( 'Ready to publish your first post?', 'componentz' ) . ' <a href="%1$s">'. esc_html__( 'Get started here', 'componentz' ) .'</a>';
                }

			    printf(
				    '<h3 class="cz-text-center">' . wp_kses(
				    /* translators: 1: link to WP admin new post page. */
    					$translate,
	    				array(
		    				'a' => array(
			    				'href' => array(),
				    		),
    					)
	    			) . '</h3>',
		    		esc_url( admin_url( 'post-new.php' ) )
    			);

            else :

                if( $count_posts->publish == 1 ) {
                    echo '<h2 class="cz-text-center">' . __( 'No more posts to display', 'componentz' ) . '</h2>';
                } else {
                    echo '<h2 class="cz-text-center">' . __( 'No content to display yet', 'componentz' ) . '</h2>';
                }

            endif;
        
            echo '<div class="no-content">'. Componentz()->svg->icon( 'cz-icon-not-found' ) .'</div>'; // phpcs:ignore

        elseif ( is_search() ) : ?>

            <h2 class="cz-text-center"><?php _e( '0 Results', 'componentz' ); ?></h2>
            <div class="no-content"><?php echo Componentz()->svg->icon( 'cz-icon-not-found' ); // phpcs:ignore ?></div>
		
        <?php else : ?>

            <h2 class="cz-text-center"><?php _e( 'Oops! We could not find it', 'componentz' ); ?></h2>
            <div class="no-content"><?php echo Componentz()->svg->icon( 'cz-icon-not-found' ); // phpcs:ignore ?></div>
        
		<?php endif; ?>   
    </div>
</section>
