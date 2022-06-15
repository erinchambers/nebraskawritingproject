<?php
/**
* The template for displaying category archive pages.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
<div class="simple-writer-posts">

<?php if ( !(simple_writer_get_option('hide_cats_title')) ) { ?>
<div class="simple-writer-page-header-outside">
<header class="simple-writer-page-header">
<div class="simple-writer-page-header-inside">
<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
<?php if ( !(simple_writer_get_option('hide_cats_description')) ) { ?><?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?><?php } ?>
</div>
</header>
</div>
<?php } ?>

<div class="simple-writer-posts-content">

<?php if (have_posts()) : ?>

    <div class="simple-writer-posts-container simple-writer-summary-posts-container simple-writer-fpw-1-column">
    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part( 'template-parts/content', 'summary' ); ?>

    <?php endwhile; ?>
    </div>
    <div class="clear"></div>

    <?php simple_writer_posts_navigation(); ?>

<?php else : ?>

  <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

</div>

</div>
</div><!--/#simple-writer-posts-wrapper -->

<?php simple_writer_after_main_content(); ?>

</div>
</div>
</div><!-- /#simple-writer-main-wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>