<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
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
 * Hook: componentz/theme/content_wrappers_end
 *
 * @hooked componentz_content_wrappers_end - 10
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/content_wrappers_end' ); 

/**
 * Hook: componentz/theme/before_footer_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/before_footer_wrapper' ); ?>

<footer id="componentz-footer">
    <div class="componentz-widgets">
        <div class="cz-container">
            <div class="cz-row">
                
                <div class="<?php Componentz()->get->copyright_class(); ?>">
                    <div class="componentz-copyright">
						
                        <?php Componentz()->get->copyright(); ?>
                        
                    </div>
                </div>
                
                <?php if( Componentz()->helper->is_footer_widgets_active() ): ?>
                <div class="cz-col-md-9 cz-order-1 cz-order-md-2">
                    <div class="cz-row">

						<?php Componentz()->get->footer_widgets(); ?>

                    </div>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</footer><!-- #componentz-footer -->

<?php
/**
 * Hook: componentz/theme/after_footer_wrapper
 *
 * @hooked componentz_search_overlay - 10
 * @hooked componentz_content_overlay - 20
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_footer_wrapper' ); ?>

</div><!-- #componentz-wrapper -->

<?php
/**
 * Hook: componentz/theme/after_main_wrapper
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/after_main_wrapper' ); ?>

<?php wp_footer(); ?>

</body>
</html>
