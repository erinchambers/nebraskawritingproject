<?php
/**
* The template for displaying 404 pages (not found).
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

get_header(); ?>

<div class='simple-writer-main-wrapper simple-writer-clearfix' id='simple-writer-main-wrapper' itemscope='itemscope' itemtype='http://schema.org/Blog' role='main'>
<div class='theiaStickySidebar'>
<div class="simple-writer-main-wrapper-inside simple-writer-clearfix">

<div class='simple-writer-posts-wrapper' id='simple-writer-posts-wrapper'>

<div class='simple-writer-posts simple-writer-singular-block'>
<div class="simple-writer-singular-block-inside">

<div class="simple-writer-page-header-outside">
<header class="simple-writer-page-header">
<div class="simple-writer-page-header-inside">
    <?php if ( simple_writer_get_option('error_404_heading') ) : ?>
    <h1 class="page-title"><?php echo esc_html( simple_writer_get_option('error_404_heading') ); ?></h1>
    <?php else : ?>
    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'simple-writer' ); ?></h1>
    <?php endif; ?>
</div>
</header><!-- .simple-writer-page-header -->
</div>

<div class='simple-writer-posts-content'>

    <?php if ( simple_writer_get_option('error_404_message') ) : ?>
    <p><?php echo wp_kses_post( force_balance_tags( simple_writer_get_option('error_404_message') ) ); ?></p>
    <?php else : ?>
    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'simple-writer' ); ?></p>
    <?php endif; ?>

    <?php if ( !(simple_writer_get_option('hide_404_search')) ) { ?><?php get_search_form(); ?><?php } ?>

</div>

</div>
</div>

</div><!--/#simple-writer-posts-wrapper -->

<?php simple_writer_404_widgets(); ?>

</div>
</div>
</div><!-- /#simple-writer-main-wrapper -->

<?php get_footer(); ?>