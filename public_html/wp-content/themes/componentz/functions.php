<?php
/**
 * Functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

use Componentz\Theme;
use Componentz\Core;

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * componentz Class
 *
 * Include componentz main class file.
 *
 * @since 1.0.0
 */
get_template_part( 'includes/class-componentz' );

/**
 * Theme Class
 *
 * Access to main componentz theme instance.
 *
 * @since 1.0.0
 */
function Componentz() {

	return Theme::get_instance();

}

/**
 * Core Class
 *
 * Include componentz core class file.
 *
 * @since 1.0.0
 */
get_template_part( 'includes/class-componentz-core' );

/**
 * Initialize Core
 *
 * Initialize componentz core class.
 *
 * @since 1.0.0
 */
Core::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
