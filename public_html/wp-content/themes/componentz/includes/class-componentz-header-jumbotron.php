<?php
/**
 * Header Jumbotron
 *
 * Display header jumbotron elements.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

namespace Componentz;

// Do not allow direct access.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Header_Jumbotron {

    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.0.0
     * @access public
     * @var null|object
     */
    public static $instance = null;

    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.0.0
     * @access public
     * @return object
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Class Constructor
     */
    function __construct() {

        $this->blog_header_content = esc_attr(
            get_theme_mod( 'componentz_blog_header_content', 'recent' )
        );

        $this->header_sticky = esc_attr(
            get_theme_mod( 'componentz_header_sticky', true )
        );

        $this->Initialize();
    }

    /**
     * Initialize
     *
     * Initialize header jumbotron.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function Initialize() {
        if( is_home() ) {

            $this->is_home();

            /**
             *  Header Dummy Content
             *
             * Add header dummy content for jQuery dynamic height -
             * if blog header content is "none" and header sticky "true" -
             * this will fix header background image/color issue.
             */
            if( 'none' == $this->blog_header_content && $this->header_sticky ) : ?>
                <div class="componentz-header-dummy"></div><?php
            endif;

        } else {

            if ( is_single() || is_page() ) {
                $this->is_single_or_page();
            }
            else if ( is_search() ) {
                $this->is_search();
            }
            else if ( is_archive() ) {
                $this->is_archive();
            }
            else if ( is_404() ) {
                $this->is_404();
            }

        }
    }
    
    /**
     * Get Post ID
     *
     * Return the post ID depends on jumbotron setting.
     *
     * @since 1.2.5
     * @access private
     * @return int
     */
    private function get_post_id() {
        $setting = get_theme_mod( 'componentz_blog_header_content', 'recent' );
        $setting = esc_attr( $setting );
        
        if( 'sticky' == $setting ) {
            $sticky_posts = get_option( 'sticky_posts' );
            $sticky_posts = array_map( 'esc_attr', $sticky_posts );
            $post_id = end( $sticky_posts );
        } else {
            $latest = get_posts("numberposts=1");
            if ( $latest[0]->ID ) {
                $post_id = $latest[0]->ID;
            }
        }
        
        return esc_attr( $post_id );
    }

    /**
     * Edit Button
     *
     * Display the edit post button.
     *
     * @param int $post_id (optional) The post ID.
     *
     * @since 1.1.2
     * @access private
     * @return mixed
     */
    private function edit_button( $post_id = null ) {
        
        if ( ! $post_id ) {
            $post_id = $this->get_post_id();
        }
        
        if ( get_edit_post_link( $post_id ) ) {
            edit_post_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( '%1$s Edit <span class="screen-reader-text">%2$s</span>', 'componentz' ),
                        [ 'span' => [ 'class' => [] ] ]
                    ),
                    Componentz()->svg->icon( 'cz-icon-pencil' ),
                    esc_html( get_the_title( $post_id ) )
                ),
                '<span class="edit-link">',
                '</span>',
                $post_id
            );
        }
    }

    /**
     * Get Post Categories
     *
     * Display given post ID categories.
     *
     * @param num $post_id (required) The ID of post to retrieve categories.
     *
     * @since 1.0.0
     * @access private
     * @return mixed
     */
    private function get_post_categories( $post_id ) {
        $categories = wp_get_post_categories( $post_id ); ?>
        <ul class="cz-d-block post-meta"><?php
                foreach( $categories as $c ) :
                    $cat    = get_category( $c );
                    $cat_id = esc_attr( $cat->term_id );
                    $link   = get_category_link( $cat_id ); ?>
                    <li class="cat-link">
                    <a href="<?php echo esc_url( $link ); ?>"
                       title="<?php echo esc_attr( $cat->name ); ?>">
                        <?php echo esc_html( $cat->name ); ?>
                    </a>
                        <?php if( next( $categories ) ) : ?>
                            <span class="dot cz-mx-2"></span>
                        <?php endif; ?>
                </li>
                <?php endforeach; ?>
        </ul><!-- .post-meta --><?php
    }

    /**
     * Get Post Meta
     *
     * Display given post ID meta details.
     *
     * @param num $post_id (optional) The ID of post to retrieve meta details.
     *
     * @since 1.0.0
     * @access private
     * @return mixed
     */
    private function get_post_meta( $post_id ) {

        // Get comments number.
        $comments = get_comments_number();

        // Format comments.
        if( '0' == $comments ) {
            $comments = __( 'Leave a Comment', 'componentz' );
        }
        else
            if( '1' == $comments ) {
                $comments = $comments . ' ' . __( 'Comment', 'componentz' );
            }
            else
                if( '1' < $comments ) {
                    $comments = $comments . ' ' . __( 'Comments', 'componentz' );
                }

        // Get archive details.
        $archive_year  = get_the_time( 'Y' );
        $archive_month = get_the_time( 'm' );
        $archive_url   = get_month_link( $archive_year, $archive_month );

        // Format post meta details. ?>
        <ul class="cz-d-block post-meta">
            <?php if( comments_open() ) : ?>
                <li>
                    <span class="comments-link">
                        <a href="<?php echo  esc_url( get_permalink() ); ?>#comments">
                            <?php echo esc_html( $comments ); ?>
                        </a>
                    </span>
                </li>
            <?php endif; ?>
            <li>
                <span class="byline"><span class="author vcard">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>"
                       title="<?php echo esc_attr( ucfirst( get_the_author() ) ); ?>">
                        <?php echo esc_html( ucfirst( get_the_author() ) ); ?>
                    </a>
                </span></span>
                <span class="dot cz-mx-2"></span></li>
            <li>
                <a href="<?php echo esc_url( $archive_url ); ?>"
                   title="<?php echo esc_attr( get_the_date() ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </a>
            </li>
        </ul><!-- .post-meta --><?php
    }

    /**
     * Recent Post
     *
     * Display recent sticky or normal posts.
     *
     * @param string $type (required) The post type to retrieve from query.
     * @param object $query (required) The posts query.
     * @param int $setting (required) The blog header content setting.
     *
     * @since 1.0.0
     * @access private
     * @return mixed
     */
    private function recent_posts( $type, $query, $setting ) {

        // Query the post.
        if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();

            if( 'sticky' == $setting ) {
                $sticky_posts = get_option( 'sticky_posts' );
                $sticky_posts = array_map( 'esc_attr', $sticky_posts );
                $post_id = end( $sticky_posts );

                // If no sticky posts, lets remove recent post id table.
                if( empty( $post_id ) ) {
                    delete_option( 'componentz_home_recent_post_id' );
                }
            } else {
                $post_id = get_the_ID();
            }

            // Store recent post ID in database.
            if( $post_id !== get_option( 'componentz_home_recent_post_id' ) ) {
                update_option( 'componentz_home_recent_post_id', esc_attr( $post_id ) );
            }

            $format = get_post_format( $post_id ) ? : 'standard';

            if ( $format != 'standard' ) {
                $format = Componentz()->svg->icon( 'cz-icon-' . $format );
            } else {
                $format = '';
            }

            if ( is_sticky( $post_id ) ) { ?>
                <span class="sticky-post page-sub cz-align-items-center cz-d-inline-flex"
                      data-aos="zoom-in-up" data-aos-duration="800">
                <?php echo esc_html_x( 'Featured', 'post', 'componentz' ); ?>
                <?php Componentz()->helper->escape_svg( $format ); //phpcs:ignore ?>
                </span><?php
            } elseif ( $format ) { ?>
                <span class="format-post page-sub" data-aos="zoom-in-up" data-aos-duration="800">
                <?php Componentz()->helper->escape_svg( $format ); //phpcs:ignore ?>
                </span><?php
            } ?>

            <h1 class="page-title" data-aos="zoom-in-up" data-aos-duration="800">
                <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                    <?php echo esc_html( get_the_title( $post_id ) ); ?>
                </a>
            </h1>

            <div data-aos="zoom-in-up" data-aos-duration="800">
            <?php $this->get_post_categories( $post_id ); ?>
            <?php $this->get_post_meta( $post_id ); ?>
            </div><?php

            // Post thumbnail.
            if( get_the_post_thumbnail( $post_id ) ) : ?>
                <div data-aos="zoom-in-up" data-aos-duration="800">
                <?php
                echo get_the_post_thumbnail(
                    $post_id,
                    'post-thumbnail',
                    [ 'class' => 'post-featured-image' ]
                ); ?>
                </div><?php
            endif;

        endwhile; endif;
        wp_reset_postdata();
    }

    /**
     * Tagline
     *
     * Display website tagline if any.
     *
     * @since 1.0.0
     * @access private
     * @return mixed
     */
    private function tagline() {
        if( get_bloginfo( 'description' ) ) : ?>
            <h1 class="page-title tagline" data-aos="zoom-in-up" data-aos-duration="800">
            <?php echo esc_html( get_bloginfo( 'description' ) ); ?>
            </h1><?php
        endif;
    }

    /**
     * Home
     *
     * Display jumbotron elements on home or front page.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function is_home() {

        $setting = get_theme_mod( 'componentz_blog_header_content', 'recent' );
        $setting = esc_attr( $setting );
        $post_id = esc_attr( get_option( 'componentz_home_recent_post_id' ) );
        $sticky  = get_option( 'sticky_posts' );
        $sticky  = array_map( 'esc_attr', $sticky );

        // Format $args.
        $args = [
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'ignore_sticky_posts' => 1
        ];

        // Init WP_Query
        $query = new \WP_Query( $args );

        if( 'recent' == $setting && $query->have_posts() || 'sticky' == $setting && ! empty( $sticky ) && 'publish' == get_post_status( end( $sticky ) ) || 'tagline' == $setting ) : ?>

            <div class="cz-container page-header cz-text-center cz-py-5 cz-overflow-hidden">
                <div class="cz-row">
                    <div class="cz-col"><?php
                        switch( $setting ) {
                            case 'recent':
                                $this->recent_posts( 'recent', $query, $setting );
                                break;
                            case 'sticky':
                                $this->recent_posts( 'sticky', $query, $setting );
                                break;
                            case 'tagline':
                                $this->tagline();
                                break;
                            case 'none':
                                // None
                                break;
                        } ?>
                    </div>
                    <?php if( 'recent' == $setting || 'sticky' == $setting ) : ?>
                        <?php $this->edit_button(); ?>
                    <?php endif; ?>
                </div><!-- .cz-row -->
            </div><!-- .page-header --><?php
        endif;
    }

    /**
     * Single or Page
     *
     * Display jumbotron elements on single posts or pages.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function is_single_or_page() {
        global $wp_query;
        if( is_single() || is_page() && ! Componentz()->helper->is_woocommerce() ) : ?>
            <div class="cz-container page-header cz-text-center cz-py-5 cz-overflow-hidden">
                <div class="cz-row">
                    <div class="cz-col"><?php

                        $format = get_post_format() ? : 'standard';

                        if ( $format != 'standard' ) {
                            $format = Componentz()->svg->icon( 'cz-icon-' . $format );
                        } else {
                            $format = '';
                        }

                        if ( is_sticky() ) { ?>
                            <span class="sticky-post page-sub cz-align-items-center cz-d-inline-flex"
                                  data-aos="zoom-in-up"
                                  data-aos-duration="800">
                            <?php echo esc_html_x( 'Featured', 'post', 'componentz' ); ?>
                            <?php Componentz()->helper->escape_svg( $format ); //phpcs:ignore ?>
                            </span><?php
                        } elseif ( $format ) { ?>
                            <span class="format-post page-sub" data-aos="zoom-in-up" data-aos-duration="800">
                            <?php Componentz()->helper->escape_svg( $format ); //phpcs:ignore ?>
                            </span><?php
                        }

                        if ( is_singular() ) {
                            the_title(
                                '<h1 class="page-title" data-aos="zoom-in-up" data-aos-duration="800">', '</h1>'
                            );
                        } else {
                            the_title(
                                sprintf(
                                    '<h2 class="page-title" data-aos="zoom-in-up" data-aos-duration="800"><a href="%s" rel="bookmark">',
                                    esc_url( get_permalink() )
                                ),
                                '</a></h2>'
                            );
                        }

                        // Non bbPress pages show post categories and meta.
                        if ( is_single() &&
                            ! Componentz()->helper->bbp_is_single_forum() &&
                            ! Componentz()->helper->is_woocommerce()
                        ) : ?>

                            <div data-aos="zoom-in-up" data-aos-duration="800">
                            <?php Componentz()->get->single_post_categories(); ?>
                            <?php Componentz()->blog->post_meta( 'header' ); ?>
                            </div><?php

                        // bbPress single forum page show post count.
                        elseif( is_single() && Componentz()->helper->bbp_is_single_forum() ) : ?>

                            <div class="post-count aos-init aos-animate" data-aos="zoom-in-up" data-aos-duration="800"><?php
                            if( 1 == bbp_get_forum_topic_count() ) {
                                _e( '1 Topic', 'componentz' );
                            } else {
                                echo esc_html( bbp_get_forum_topic_count() ) . ' ' . __( 'Topics', 'componentz' );
                            } ?>
                            </div><?php

                        // WooCommerce single product pages.
                        elseif( is_single() && Componentz()->helper->is_woocommerce() ) : ?>
                            <div data-aos="zoom-in-up" data-aos-duration="800">
                            <?php Componentz()->get->single_product_categories(); ?>
                            </div><?php
                        endif;

                        // Do not show thumb on WC product.
                        if( ! Componentz()->helper->is_woocommerce() ) : ?>
                            <div class="aos-item" data-aos="zoom-in-up" data-aos-duration="800">
                            <?php Componentz()->blog->thumbnail(); ?>
                            </div><?php
                        endif; ?>
                    </div>
                    <?php $this->edit_button( get_the_ID() ); ?>
                </div><!-- .cz-row -->
            </div><!-- .page-header --><?php
        endif;
    }

    /**
     * Search
     *
     * Display jumbotron elements on search page.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function is_search() {
        if( is_search() ) : ?>
            <div class="cz-container page-header cz-text-center cz-py-5">
                <div class="cz-row">
                    <div class="cz-col">
                        <h1 class="page-title" data-aos="zoom-in-up" data-aos-duration="800">
                            <?php _e( 'Search Results', 'componentz' ); ?>
                        </h1>
                        <?php echo get_search_form( false ); ?>
                    </div>
                </div>
            </div><!-- .page-header --><?php
        endif;
    }

    /**
     * Archive
     *
     * Display jumbotron elements on archive pages.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function is_archive() {
        if( is_archive() ) {

            global $post, $wp_query; ?>

            <div class="cz-container page-header cz-text-center cz-py-5">
                <div class="cz-row">
                    <div class="cz-col">

                        <?php if ( is_author() ) { ?>
                            <span class="page-sub" data-aos="zoom-in-up" data-aos-duration="800">
                            <?php _e( 'Author', 'componentz' ); ?>
                            </span><?php
                        }
                        else
                            if( is_category() ) { ?>
                                <span class="page-sub" data-aos="zoom-in-up" data-aos-duration="800">
                                <?php _e( 'Category', 'componentz' ); ?>
                                </span><?php
                            }
                            else
                                if( is_tag() ) { ?>
                                    <span class="page-sub" data-aos="zoom-in-up" data-aos-duration="800">
                                    <?php _e( 'Tag', 'componentz' ); ?>
                                    </span><?php
                                } else {
                                    if( ! Componentz()->helper->is_woocommerce() &&
                                        ! Componentz()->helper->is_bbpress() )
                                    { ?>
                                        <span class="page-sub" data-aos="zoom-in-up" data-aos-duration="800">
                                        <?php _e( 'Archive', 'componentz' ); ?>
                                        </span><?php
                                    }
                                }

                        if( is_author() ) : ?>
                            <div class="cz-mb-2 avatar" data-aos="zoom-in-up" data-aos-duration="800">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), '60' ); ?>
                            </div><?php
                        endif; ?>

                        <h1 class="page-title" data-aos="zoom-in-up" data-aos-duration="800"><?php
                            if ( is_author() ) {
                                the_author();
                            }
                            else
                                if ( is_category() ) {
                                    single_cat_title();
                                }
                                else
                                    if ( is_tag() ) {
                                        single_tag_title();
                                    }
                                    else
                                        if ( Componentz()->helper->is_bbpress() ) {
                                            echo esc_html( $post->post_title );
                                        }
                                        else
                                            if ( Componentz()->helper->is_shop() ) {
                                                woocommerce_page_title();
                                            } else {
                                                the_archive_title();
                                            } ?>
                        </h1>

                        <div class="post-count" data-aos="zoom-in-up" data-aos-duration="800"><?php
                            if( is_author() ) {
                                $count = count_user_posts( $post->post_author );
                            } else {
                                $count = $wp_query->found_posts; // Count archive posts.
                            }

                            // Label
                            if( $count == 1 ) { // Singular
                                if( Componentz()->helper->bbp_is_forum_archive() ) {
                                    $label_count = __( 'Forum', 'componentz' );
                                }
                                else
                                    if( Componentz()->helper->bbp_is_single_forum() ) {
                                        $label_count = __( 'Topic', 'componentz' );
                                    }
                                    else
                                        if( Componentz()->helper->is_shop() || Componentz()->helper->is_woocommerce() ) {
                                            $label_count = __( 'Product', 'componentz' );
                                        } else {
                                            $label_count = __( 'Post', 'componentz' );
                                        }
                            } else { // Plural
                                if( Componentz()->helper->bbp_is_forum_archive() ) {
                                    $label_count = __( 'Forums', 'componentz' );
                                }
                                else
                                    if( Componentz()->helper->bbp_is_single_forum() ) {
                                        $label_count = __( 'Topics', 'componentz' );
                                    }
                                    else
                                        if( Componentz()->helper->is_shop() || Componentz()->helper->is_woocommerce() ) {
                                            $label_count = __( 'Products', 'componentz' );
                                        } else {
                                            $label_count = __( 'Posts', 'componentz' );
                                        }
                            }

                            echo esc_html( $count ) .' '. esc_html( $label_count ); // phpcs:ignore ?>
                        </div><!-- .post-count -->

                    </div><!-- .cz-col -->
                </div><!-- .cz-row -->
            </div><!-- .page-header --><?php
        }
    }

    /**
     * The 404 Page
     *
     * Display jumbotron elements on 404 page.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function is_404() {
        if( is_404() ) : ?>
            <div class="cz-container page-header cz-text-center cz-py-5">
                <div class="cz-row">
                    <div class="cz-col">
                        <h1 class="page-title" data-aos="zoom-in-up" data-aos-duration="800">
                            <?php _e( 'Error 404', 'componentz' ); ?>
                        </h1>
                        <?php echo get_search_form( false ); ?>
                    </div>
                </div>
            </div><!-- .page-header --><?php
        endif;
    }

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
