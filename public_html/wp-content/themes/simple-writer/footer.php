<?php
/**
* The template for displaying the footer
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

</div>

</div><!--/#simple-writer-content-wrapper -->
</div><!--/#simple-writer-wrapper -->

<div class="simple-writer-outer-wrapper">
<?php simple_writer_bottom_wide_widgets(); ?>
</div>

<?php simple_writer_before_footer(); ?>

<?php if ( !(simple_writer_hide_footer_widgets()) ) { ?>
<?php if ( is_active_sidebar( 'simple-writer-footer-1' ) || is_active_sidebar( 'simple-writer-footer-2' ) || is_active_sidebar( 'simple-writer-footer-3' ) || is_active_sidebar( 'simple-writer-footer-4' ) || is_active_sidebar( 'simple-writer-top-footer' ) || is_active_sidebar( 'simple-writer-bottom-footer' ) ) : ?>
<div class='simple-writer-clearfix' id='simple-writer-footer-blocks' itemscope='itemscope' itemtype='http://schema.org/WPFooter' role='contentinfo'>
<div class='simple-writer-container simple-writer-clearfix'>
<div class="simple-writer-outer-wrapper">

<?php if ( is_active_sidebar( 'simple-writer-top-footer' ) ) : ?>
<div class='simple-writer-clearfix'>
<div class='simple-writer-top-footer-block'>
<?php dynamic_sidebar( 'simple-writer-top-footer' ); ?>
</div>
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'simple-writer-footer-1' ) || is_active_sidebar( 'simple-writer-footer-2' ) || is_active_sidebar( 'simple-writer-footer-3' ) || is_active_sidebar( 'simple-writer-footer-4' ) ) : ?>
<div class='simple-writer-footer-block-cols simple-writer-clearfix'>

<div class="simple-writer-footer-block-col simple-writer-footer-4-col" id="simple-writer-footer-block-1">
<?php dynamic_sidebar( 'simple-writer-footer-1' ); ?>
</div>

<div class="simple-writer-footer-block-col simple-writer-footer-4-col" id="simple-writer-footer-block-2">
<?php dynamic_sidebar( 'simple-writer-footer-2' ); ?>
</div>

<div class="simple-writer-footer-block-col simple-writer-footer-4-col" id="simple-writer-footer-block-3">
<?php dynamic_sidebar( 'simple-writer-footer-3' ); ?>
</div>

<div class="simple-writer-footer-block-col simple-writer-footer-4-col" id="simple-writer-footer-block-4">
<?php dynamic_sidebar( 'simple-writer-footer-4' ); ?>
</div>

</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'simple-writer-bottom-footer' ) ) : ?>
<div class='simple-writer-clearfix'>
<div class='simple-writer-bottom-footer-block'>
<?php dynamic_sidebar( 'simple-writer-bottom-footer' ); ?>
</div>
</div>
<?php endif; ?>

</div>
</div>
</div><!--/#simple-writer-footer-blocks-->
<?php endif; ?>
<?php } ?>

<div class="simple-writer-clearfix" id="simple-writer-site-bottom">
<div class="simple-writer-site-bottom-inside simple-writer-container">
<div class="simple-writer-outer-wrapper">

<?php if ( simple_writer_get_option('footer_text') ) : ?>
  <p class='simple-writer-copyright'><?php echo esc_html(simple_writer_get_option('footer_text')); ?></p>
<?php else : ?>
  <p class='simple-writer-copyright'><?php /* translators: %s: Year and site name. */ printf( esc_html__( 'Copyright &copy; %s', 'simple-writer' ), esc_html(date_i18n(__('Y','simple-writer'))) . ' ' . esc_html(get_bloginfo( 'name' ))  ); ?></p>
<?php endif; ?>
<p class='simple-writer-credit'><a href="<?php echo esc_url( 'https://themesdna.com/' ); ?>"><?php /* translators: %s: Theme author. */ printf( esc_html__( 'Design by %s', 'simple-writer' ), 'ThemesDNA.com' ); ?></a></p>

</div>
</div>
</div><!--/#simple-writer-site-bottom -->

<?php simple_writer_after_footer(); ?>

</div>

<?php if ( simple_writer_is_backtotop_active() ) { ?><button class="simple-writer-scroll-top" title="<?php esc_attr_e('Scroll to Top','simple-writer'); ?>"><i class="fas fa-arrow-up" aria-hidden="true"></i><span class="simple-writer-sr-only"><?php esc_html_e('Scroll to Top', 'simple-writer'); ?></span></button><?php } ?>

<?php wp_footer(); ?>
</body>
</html>