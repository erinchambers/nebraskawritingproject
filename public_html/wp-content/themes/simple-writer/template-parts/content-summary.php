<?php
/**
* Template part for displaying posts.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<div class="simple-writer-summary-post-wrapper">
<div id="post-<?php the_ID(); ?>" class="simple-writer-summary-post simple-writer-item-post simple-writer-summary-block">
<div class="simple-writer-summary-block-inside">

    <?php if ( !(simple_writer_get_option('hide_post_header_home')) ) { ?>
    <div class="simple-writer-summary-post-title-outer simple-writer-summary-post-block">
    <div class="simple-writer-summary-post-title-wrapper">
    <?php the_title( sprintf( '<h2 class="simple-writer-summary-post-title simple-writer-fp-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    </div>
    </div>
    <?php } ?>

    <?php if ( !(simple_writer_get_option('hide_post_data_home')) ) { ?>
    <div class="simple-writer-summary-post-data simple-writer-summary-post-block">
    <div class="simple-writer-summary-post-data-inside">

    <?php if ( !(simple_writer_get_option('hide_post_author_image')) ) { ?><?php echo wp_kses_post( simple_writer_author_image() ); ?><?php } ?>

    <?php simple_writer_summaryview_postmeta(); ?>

    <?php simple_writer_summaryview_footer(); ?>

    </div>
    </div>
    <?php } ?>

    <div class="simple-writer-summary-post-details simple-writer-summary-post-block">
    <?php if ( !(simple_writer_get_option('hide_thumbnail_home')) ) { ?>
    <?php if ( has_post_thumbnail() ) { ?>
        <div class="simple-writer-summary-post-detail-block simple-writer-summary-post-thumbnail simple-writer-fp-post-thumbnail <?php echo esc_attr(simple_writer_summary_thumb_style_class()); ?>">
            <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'simple-writer' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="simple-writer-summary-post-thumbnail-link simple-writer-fp-post-thumbnail-link"><?php the_post_thumbnail(simple_writer_summary_thumb_style(), array('class' => 'simple-writer-summary-post-thumbnail-img simple-writer-fp-post-thumbnail-img', 'title' => the_title_attribute('echo=0'))); ?></a>
        </div>
    <?php } else { ?>
        <?php if ( simple_writer_get_option('show_default_thumbnail_home') ) { ?>
        <div class="simple-writer-summary-post-detail-block simple-writer-summary-post-thumbnail simple-writer-fp-post-thumbnail <?php echo esc_attr(simple_writer_summary_thumb_style_class()); ?>">
            <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'simple-writer' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="simple-writer-summary-post-thumbnail-link simple-writer-fp-post-thumbnail-link"><img src="<?php echo esc_url( simple_writer_summary_no_thumb_image() ); ?>" class="simple-writer-summary-post-thumbnail-img simple-writer-fp-post-thumbnail-img"/></a>
        </div>
        <?php } ?>
    <?php } ?>
    <?php } ?>

    <?php if ( !(simple_writer_get_option('hide_post_snippet')) ) { ?>
    <?php if ( 'post-snippets' === simple_writer_post_content_type() ) { ?>
        <div class="simple-writer-summary-post-detail-block simple-writer-summary-post-snippet simple-writer-fp-post-snippet simple-writer-summary-post-excerpt simple-writer-fp-post-excerpt"><?php the_excerpt(); ?></div>
    <?php } else { ?>
        <div class="simple-writer-summary-post-detail-block simple-writer-summary-post-content simple-writer-fp-post-content">
        <?php
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
        </div>
    <?php } ?>
    <?php } ?>

    <?php if ( 'post-snippets' === simple_writer_post_content_type() ) { ?><?php if ( !(simple_writer_get_option('hide_read_more_button')) ) { ?><div class="simple-writer-summary-post-detail-block simple-writer-summary-post-read-more simple-writer-fp-post-read-more"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( simple_writer_read_more_text() ); ?><span class="simple-writer-sr-only"> <?php echo wp_kses_post( get_the_title() ); ?></span></a></div><?php } ?><?php } ?>
    </div>

</div>
</div>
</div>