<?php
/**
* Template part for displaying single posts.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<?php simple_writer_before_single_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('simple-writer-post-singular simple-writer-singular-block'); ?>>
<div class="simple-writer-singular-block-inside">

    <?php if ( !(simple_writer_get_option('hide_post_title')) ) { ?>
    <header class="entry-header">
    <div class="entry-header-inside">
        <?php if ( simple_writer_get_option('remove_post_title_link') ) { ?>
            <?php the_title( '<h1 class="post-title entry-title">', '</h1>' ); ?>
        <?php } else { ?>
            <?php the_title( sprintf( '<h1 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
        <?php } ?>
    </div>
    </header><!-- .entry-header -->
    <?php } ?>

    <?php if ( !(simple_writer_get_option('hide_post_data')) ) { ?>
    <div class="simple-writer-singleview-post-data simple-writer-singleview-post-block">
    <div class="simple-writer-singleview-post-data-inside">
        <?php simple_writer_singleview_postmeta(); ?>
        <?php simple_writer_singleview_footer(); ?>
    </div>
    </div>
    <?php } ?>

    <?php simple_writer_after_single_post_title(); ?>

    <div class="entry-content simple-writer-clearfix">
        <?php
        if ( has_post_thumbnail() ) {
            if ( !(simple_writer_get_option('hide_thumbnail_single')) ) {
                if ( simple_writer_get_option('thumbnail_link') == 'no' ) { ?>
                    <div class="simple-writer-post-thumbnail-single">
                    <?php
                    if ( is_page_template( array( 'template-full-width-post.php', 'template-full-width-post-sidebar.php' ) ) ) {
                        the_post_thumbnail('simple-writer-1130w-autoh-image', array('class' => 'simple-writer-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                    } else {
                        the_post_thumbnail('simple-writer-760w-autoh-image', array('class' => 'simple-writer-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                    }
                    ?>
                    </div>
                <?php } else { ?>
                    <div class="simple-writer-post-thumbnail-single">
                    <?php if ( is_page_template( array( 'template-full-width-post.php', 'template-full-width-post-sidebar.php' ) ) ) { ?>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'simple-writer' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="simple-writer-post-thumbnail-single-link"><?php the_post_thumbnail('simple-writer-1130w-autoh-image', array('class' => 'simple-writer-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                    <?php } else { ?>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'simple-writer' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="simple-writer-post-thumbnail-single-link"><?php the_post_thumbnail('simple-writer-760w-autoh-image', array('class' => 'simple-writer-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                    <?php } ?>
                    </div>
        <?php   }
            }
        }

        the_content( sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __( 'Continue reading<span class="simple-writer-sr-only"> "%s"</span> <span class="meta-nav">&rarr;</span>', 'simple-writer' ),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            wp_kses_post( get_the_title() )
        ) );

        wp_link_pages( array(
         'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'simple-writer' ) . '</span>',
         'after'       => '</div>',
         'link_before' => '<span>',
         'link_after'  => '</span>',
         ) );
         ?>
    </div><!-- .entry-content -->

    <?php simple_writer_after_single_post_content(); ?>

    <?php if ( !(simple_writer_get_option('hide_author_bio_box')) ) { echo wp_kses_post( force_balance_tags( simple_writer_add_author_bio_box() ) ); } ?>

</div>
</article>

<?php simple_writer_after_single_post(); ?>