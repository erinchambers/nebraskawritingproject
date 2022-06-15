<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until #content.
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
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="profile" href="https://gmpg.org/xfn/11"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>><?php

/**
 * Body Open
 *
 * Fire the wp_body_open action.
 * 
 * @since 1.0.3
 */
wp_body_open();
    
/**
 * Hook: componentz/theme/before_main_wrapper
 *
 * @hooked componentz_preloader - 5
 *
 * @since 1.0.0
 */
do_action( 'componentz/theme/before_main_wrapper' ); ?>

<div id="componentz-wrapper" class="<?php Componentz()->get->wrapper_class(); ?>">

    <a class="screen-reader-text" href="#content">
        <?php _e( 'Skip to content', 'componentz' ); ?>
    </a><!-- .screen-reader-text -->

	<?php
	/**
	 * Hook: componentz/theme/before_header_wrapper
     *
     * @hooked none
	 *
	 * @since 1.0.0
	 */
	do_action( 'componentz/theme/before_header_wrapper' ); ?>

    <header id="componentz-header" class="<?php Componentz()->get->header_class(); ?>">
        <div class="header-background">
        <?php
        /**
         * Hook: componentz/theme/header
         *
         * @hooked componentz_header - 10
         * @hooked componentz_header_image - 20
         * @hooked componentz_header_jumbotron - 30
         *
         * @since 1.0.0
         */
        do_action( 'componentz/theme/header' ); ?>
        </div><!-- .header-background -->
    </header><!-- #componentz-header -->

	<?php
	/**
	 * Hook: componentz/theme/after_header_wrapper
     * 
     * @hooked componentz_sticky_posts - 10
	 *
	 * @since 1.0.0
	 */
	do_action( 'componentz/theme/after_header_wrapper' );

    /**
     * Hook: componentz/theme/content_wrappers_start
     *
     * @hooked componentz_content_wrappers_start - 10
     *
     * @since 1.0.0
     */
    do_action( 'componentz/theme/content_wrappers_start' ); ?>
        