<?php
/**
* The header for Simple Writer theme.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class('simple-writer-animated simple-writer-fadein'); ?> id="simple-writer-site-body" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#simple-writer-posts-wrapper"><?php esc_html_e( 'Skip to content', 'simple-writer' ); ?></a>

<div class="simple-writer-site-wrapper">

<?php simple_writer_header_image(); ?>

<?php simple_writer_before_header(); ?>

<div class="simple-writer-container" id="simple-writer-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
<?php if ( simple_writer_is_header_content_active() ) { ?>
<div class="simple-writer-head-content simple-writer-clearfix" id="simple-writer-head-content">
<div class="simple-writer-outer-wrapper">
<div class="simple-writer-header-inside simple-writer-clearfix">
<div class="simple-writer-header-inside-content simple-writer-clearfix">

<div class="simple-writer-logo">
<?php if ( has_custom_logo() ) : ?>
    <div class="site-branding">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="simple-writer-logo-img-link">
        <img src="<?php echo esc_url( simple_writer_custom_logo() ); ?>" alt="" class="simple-writer-logo-img"/>
    </a>
    <div class="simple-writer-custom-logo-info"><?php simple_writer_site_title(); ?></div>
    </div>
<?php else: ?>
    <div class="site-branding">
      <?php simple_writer_site_title(); ?>
    </div>
<?php endif; ?>
</div>

<div class="simple-writer-header-social">
<?php if ( simple_writer_is_header_social_buttons_active() ) { ?>
<?php simple_writer_header_social_buttons(); ?>
<?php } ?>
</div><!--/.simple-writer-header-social -->

</div>
</div>
</div><!--/#simple-writer-head-content -->
</div><!--/#simple-writer-header -->
<?php } else { ?>
<div class="simple-writer-no-header-content">
<div class="simple-writer-outer-wrapper">
  <?php simple_writer_site_title(); ?>
</div>
</div>
<?php } ?>
</div>

<?php simple_writer_after_header(); ?>

<div id="simple-writer-search-overlay-wrap" class="simple-writer-search-overlay">
  <div class="simple-writer-search-overlay-content">
    <?php get_search_form(); ?>
  </div>
  <button class="simple-writer-search-closebtn" aria-label="<?php esc_attr_e( 'Close Search', 'simple-writer' ); ?>" title="<?php esc_attr_e('Close Search','simple-writer'); ?>">&#xD7;</button>
</div>

<?php if ( simple_writer_is_primary_menu_active() ) { ?>
<div class="simple-writer-container simple-writer-primary-menu-container simple-writer-clearfix">
<div class="simple-writer-primary-menu-container-inside simple-writer-clearfix">

<nav class="simple-writer-nav-primary" id="simple-writer-primary-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'simple-writer' ); ?>">
<div class="simple-writer-outer-wrapper">
<button class="simple-writer-primary-responsive-menu-icon" aria-controls="simple-writer-menu-primary-navigation" aria-expanded="false"><?php esc_html_e( 'Menu', 'simple-writer' ); ?></button>
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'simple-writer-menu-primary-navigation', 'menu_class' => 'simple-writer-primary-nav-menu simple-writer-menu-primary', 'fallback_cb' => 'simple_writer_fallback_menu', 'container' => '', ) ); ?>
</div>
</nav>

</div>
</div>
<?php } ?>

<div class="simple-writer-outer-wrapper">
<?php simple_writer_top_wide_widgets(); ?>
</div>

<div class="simple-writer-outer-wrapper" id="simple-writer-wrapper-outside">

<div class="simple-writer-container simple-writer-clearfix" id="simple-writer-wrapper">
<div class="simple-writer-content-wrapper simple-writer-clearfix" id="simple-writer-content-wrapper">