<?php
/**
* Simple Writer functions and definitions.
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

define( 'SIMPLE_WRITER_PROURL', 'https://themesdna.com/simple-writer-pro-wordpress-theme/' );
define( 'SIMPLE_WRITER_CONTACTURL', 'https://themesdna.com/contact/' );
define( 'SIMPLE_WRITER_THEMEOPTIONSDIR', get_template_directory() . '/inc' );

require_once( SIMPLE_WRITER_THEMEOPTIONSDIR . '/customizer.php' );

/**
 * This function return a value of given theme option name from database.
 *
 * @since 1.0.0
 *
 * @param string $option Theme option to return.
 * @return mixed The value of theme option.
 */
function simple_writer_get_option($option) {
    $simple_writer_options = get_option('simple_writer_options');
    if ((is_array($simple_writer_options)) && (array_key_exists($option, $simple_writer_options))) {
        return $simple_writer_options[$option];
    } else {
        return '';
    }
}

function simple_writer_is_option_set($option) {
    $simple_writer_options = get_option('simple_writer_options');
    if ((is_array($simple_writer_options)) && (array_key_exists($option, $simple_writer_options))) {
        return true;
    } else {
        return false;
    }
}

if ( ! function_exists( 'simple_writer_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function simple_writer_setup() {
    
    global $wp_version;

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Simple Writer, use a find and replace
     * to change 'simple-writer' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'simple-writer', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );

    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'simple-writer-1130w-autoh-image',  1130, 9999, false );
        add_image_size( 'simple-writer-760w-autoh-image',  760, 9999, false );
        add_image_size( 'simple-writer-760w-450h-image',  760, 450, true );
    }

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
    'primary' => esc_html__('Primary Menu', 'simple-writer')
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    $markup = array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' );
    add_theme_support( 'html5', $markup );

    add_theme_support( 'custom-logo', array(
        'height'      => 70,
        'width'       => 350,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    // Support for Custom Header
    add_theme_support( 'custom-header', apply_filters( 'simple_writer_custom_header_args', array(
    'default-image'          => '',
    'default-text-color'     => '000000',
    'width'                  => 1920,
    'height'                 => 400,
    'flex-width'            => true,
    'flex-height'            => true,
    'wp-head-callback'       => 'simple_writer_header_style',
    'uploads'                => true,
    ) ) );

    // Set up the WordPress core custom background feature.
    $background_args = array(
            'default-color'          => 'e6e6e6',
            'default-image'          => get_template_directory_uri() .'/assets/images/background.png',
            'default-repeat'         => 'repeat',
            'default-position-x'     => 'left',
            'default-position-y'     => 'top',
            'default-size'     => 'auto',
            'default-attachment'     => 'fixed',
            'wp-head-callback'       => '_custom_background_cb',
            'admin-head-callback'    => 'admin_head_callback_func',
            'admin-preview-callback' => 'admin_preview_callback_func',
    );
    add_theme_support( 'custom-background', apply_filters( 'simple_writer_custom_background_args', $background_args) );
    
    // Support for Custom Editor Style
    add_editor_style( 'css/editor-style.css' );

    if ( !(simple_writer_get_option('enable_widgets_block_editor')) ) {
        remove_theme_support( 'widgets-block-editor' );
    }

}
endif;
add_action( 'after_setup_theme', 'simple_writer_setup' );

require_once( trailingslashit( get_template_directory() ) . 'inc/init.php' );