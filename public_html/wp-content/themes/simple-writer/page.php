<?php
/**
* The template for displaying all pages.
*
* This is the template that displays all pages by default.
* Please note that this is the WordPress construct of pages
* and that other 'pages' on your WordPress site may use a
* different template.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

get_header(); ?>

<div class="simple-writer-main-wrapper simple-writer-clearfix" id="simple-writer-main-wrapper" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
<div class="theiaStickySidebar">
<div class="simple-writer-main-wrapper-inside simple-writer-clearfix">

<?php simple_writer_before_main_content(); ?>

<div class="simple-writer-posts-wrapper" id="simple-writer-posts-wrapper">

<?php while (have_posts()) : the_post();

    get_template_part( 'template-parts/content', 'page' );

    if ( !(simple_writer_get_option('hide_page_comment_form')) ) {

    // If comments are open or we have at least one comment, load up the comment template
    if ( comments_open() || get_comments_number() ) :
            comments_template();
    endif;

    }

endwhile; ?>

<div class="clear"></div>
</div><!--/#simple-writer-posts-wrapper -->

<?php simple_writer_after_main_content(); ?>

</div>
</div>
</div><!-- /#simple-writer-main-wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>