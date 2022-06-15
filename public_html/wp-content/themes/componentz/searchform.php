<?php
/**
 * Searchform
 *
 * The custom searchform of the theme.
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

$componentz_unique_id = Componentz()->get->unique_id( 'search-input-' );

?>

<!-- Searchform -->
<form action="<?php echo esc_url( home_url() ); ?>" method="get" class="search-form">
    <label class="screen-reader-text" for="<?php echo $componentz_unique_id; ?>"><?php _e( 'Search the website', 'componentz' ); ?></label>
    <input id="<?php echo $componentz_unique_id; ?>" class="cz-form-control" type="text" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search the website', 'componentz' ); ?>"/>
    <button class="search-button" type="submit"><span class="screen-reader-text"><?php _e( 'Search', 'componentz' ); ?></span><?php echo is_rtl() ? Componentz()->svg->icon( 'cz-icon-arrow-left' ) : Componentz()->svg->icon( 'cz-icon-arrow-right' ); // phpcs:ignore ?></button>
</form><!-- Searchform End -->
