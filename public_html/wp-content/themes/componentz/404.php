<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

get_header(); 

/**
 * Hook: componentz/theme/before_primary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/before_primary_wrapper' ); ?>

    <section id="primary" class="<?php Componentz()->get->primary_class(); ?>">
        <div class="error-404 not-found">
            <div class="page-content">
                <h2 class="cz-text-center"><?php _e( 'Oops! That page can&rsquo;t be found', 'componentz' ); ?></h2>
                <div class="no-content"><?php echo Componentz()->svg->icon( 'cz-icon-not-found' ); // phpcs:ignore ?></div>
            </div>
        </div>
    </section>

<?php
/**
 * Hook: componentz/theme/after_primary_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_primary_wrapper' );

get_footer(); ?>
