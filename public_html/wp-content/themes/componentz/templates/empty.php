<?php
/**
 * Template Name: Empty
 *
 * Componentz empty template with header and footer only.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
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
 * Hook: componentz/theme/template_empty
 *
 * @hooked none
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/template_empty' );

get_footer();
