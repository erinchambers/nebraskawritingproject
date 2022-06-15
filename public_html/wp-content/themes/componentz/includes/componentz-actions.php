<?php
/**
 * Componentz Actions
 *
 * Actions are the hooks that the WordPress core launches at specific points during execution,
 * or when specific events occur. Plugins can specify that one or more of its PHP functions are
 * executed at these points, using the Action API.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

use Componentz\Header_Image;
use Componentz\Header_Jumbotron;

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Home Query
 *
 * Modify home page posts query.
 * Exclude post in header area from home page posts.
 *
 * @param array $query (required) The posts query.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_home_query( $query ) {
    $setting = esc_attr( get_theme_mod( 'componentz_blog_header_content', 'recent' ) );
    // Run only on home page and if recent or sticky post enabled in header area.
    if ( 
         $query->is_home() && $query->is_main_query() && 'recent' == $setting || 
         $query->is_home() && $query->is_main_query() && 'sticky' == $setting 
       ) 
    {
        $post_id = '';
        $setting = esc_attr( get_theme_mod( 'componentz_blog_header_content', 'recent' ) );

        // Sticky post.
        if( 'sticky' == $setting ) {
            $sticky_posts = get_option( 'sticky_posts' );
            $sticky_posts = array_map( 'esc_attr', $sticky_posts );

            if( ! empty( $sticky_posts ) ) {
                $post_id = end( $sticky_posts );
            }
        }
        else // Recent post.
        if( 'recent' == $setting ) { 
            $recent_posts = wp_get_recent_posts( [ 'post_status' => 'publish' ] );
            if( ! empty( $recent_posts[0]['ID'] ) ) {
                $post_id = esc_attr( $recent_posts[0]['ID'] );
            }
        }

        if( ! empty( $post_id ) ) {
            $query->set( 'post__not_in', [ $post_id ] );
        }
    }
}
add_action( 'pre_get_posts', 'componentz_home_query' );

/**
 * Preloader
 *
 * The page preloader transition effect.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_preloader() { ?>
    <?php if( get_theme_mod( 'componentz_preloader', false ) ) : ?>
    <div id="fader">
        <svg id="loader-image" width="300px" height="200px" viewBox="0 0 187.3 93.7" preserveAspectRatio="xMidYMid meet">
            <path id="outline" stroke="#0d55ff" fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M93.9,46.4c9.3,9.5,13.8,17.9,23.5,17.9s17.5-7.8,17.5-17.5s-7.8-17.6-17.5-17.5c-9.7,0.1-13.3,7.2-22.1,17.1 c-8.9,8.8-15.7,17.9-25.4,17.9s-17.5-7.8-17.5-17.5s7.8-17.5,17.5-17.5S86.2,38.6,93.9,46.4z" />
            <path id="outline-bg" opacity="0.05" fill="none" stroke="#0d55ff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M93.9,46.4c9.3,9.5,13.8,17.9,23.5,17.9s17.5-7.8,17.5-17.5s-7.8-17.6-17.5-17.5c-9.7,0.1-13.3,7.2-22.1,17.1 c-8.9,8.8-15.7,17.9-25.4,17.9s-17.5-7.8-17.5-17.5s7.8-17.5,17.5-17.5S86.2,38.6,93.9,46.4z" />
        </svg>
    </div><!-- #fader -->
    <?php
    endif;
}
add_action( 'componentz/theme/before_main_wrapper', 'componentz_preloader', 5 );

/**
 * Componentz Header
 *
 * Initialize componentz theme header. 
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_header() {

    // Get current componentz header style chosen in customizer setting.
    $style = esc_attr( get_theme_mod( 'componentz_header_style', 'v1' ) );

    // Get all componentz headers.
    $headers = componentz_header_styles(); 

    // Assign current header filename and directory path.
    $filename = isset( $headers[$style]['filename'] ) ? esc_attr( $headers[$style]['filename'] ) : '';
    $path     = isset( $headers[$style]['path'] ) ? esc_attr( $headers[$style]['path'] ) : '';
    $header   = $path . $filename;

    // Let's check if header filename exists. If exists include it.
    if( file_exists( $header ) ) {
        require_once( $header ); // phpcs:ignore
    } else { // Else if header file not exists let's include default componentz header (v1).
        get_template_part( 'template-parts/header/header-v1' ); // phpcs:ignore
    }
}
add_action( 'componentz/theme/header', 'componentz_header', 10 );

/**
 * Header Image
 *
 * Initialize the componentz theme header image.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_header_image() {
    Header_Image::get_instance();
}
add_action( 'componentz/theme/header', 'componentz_header_image', 20 );

/**
 * Header Jumbotron
 * 
 * Initialize the componentz theme header jumbotron.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_header_jumbotron() {
    Header_Jumbotron::get_instance();
}
add_action( 'componentz/theme/header', 'componentz_header_jumbotron', 30 );

/**
 * Sticky Posts
 *
 * Initialize the sticky posts section.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_sticky_posts() {
    if( is_archive() ) {

        $args       = [];
        $cat_ID     = [];
        $author     = get_query_var( 'author' );
        $year       = get_query_var( 'year' );
        $monthnum   = get_query_var( 'monthnum' );
        $tag        = get_query_var( 'tag' );
        $sticky     = get_option( 'sticky_posts' );
        $sticky     = array_map( 'esc_attr', $sticky );
        $categories = get_the_category();

        if( is_array( $categories ) && ! empty( $categories ) ) {
            foreach( $categories as $category ) {
                $cat_ID[] = esc_attr( $category->cat_ID );
            }
        }

        $default = [
            'post__in' => $sticky,
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 4
        ];

        if( is_month() ) {
            $args = [
                'year' => $year,
                'monthnum' => $monthnum
            ];

            $args = array_merge( $default, $args );
        }
        else
        if( is_author() ) {
            $args = [
                'author' => $author
            ];

            $args = array_merge( $default, $args );
        }
        else
        if( is_category() ) {
            $args = [
                'category__in' => $cat_ID
            ];

            $args = array_merge( $default, $args );
        }
        else
        if( is_tag() ) {
            $args = [
                'tag' => $tag
            ];

            $args = array_merge( $default, $args );
        }

        $query = new \WP_Query( $args );

        if ( $query->have_posts() ) { ?>
        <div id="featured-posts">
            <div class="cz-container">
                <h2><?php esc_html_e( 'Featured', 'componentz' ); ?></h2>
                    <div class="cz-row cz-justify-content-center card-wrapper">
                    <?php while ( $query->have_posts() ) :
                        $query->the_post();

                        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        $category  = Componentz()->helper->post_categories( get_the_ID() ); ?>

                        <div class="cz-col-sm-6 cz-col-xl-3 cz-mb-5 cz-mb-xl-0">
                            <div class="cz-card">
                            <?php if ( has_post_thumbnail() ) : ?>

                                <a href="<?php echo esc_url( get_permalink() ); ?>" 
                                   title="<?php echo esc_attr( get_the_title() ); ?>">

                                <?php if( ! empty( $category[0]) || ! empty( $category[1] ) ) : ?>
                                    <span class="categories">
                                        <?php if ( ! empty( $category[0] ) ) : ?>
                                            <span class="category">
                                                <?php echo esc_html( $category[0]['name'] ); ?>
                                            </span>
                                        <?php endif; 
                                        if ( ! empty( $category[1] ) ) : ?>
                                            <span class="category">
                                                <?php echo esc_html( $category[1]['name'] ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>

                                <div class="featured-image-wrapper">
                                <img class="cz-card-img-top" src="<?php echo esc_url( $image_url[0] ); ?>" 
                                     alt="<?php echo esc_attr( get_the_title() ); ?>">
                                </div>
                                </a>
                            <?php endif; ?>
                                <div class="cz-card-body">
                                    <?php echo Componentz()->meta->author(); //phpcs:ignore ?>
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" 
                                       title="<?php echo esc_attr( get_the_title() ); ?>">
                                        <h5 class="cz-card-title">
                                            <?php echo esc_html( get_the_title() ); ?>
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </div>
            </div>
        </div>
        <?php
        }
    }
}
add_action( 'componentz/theme/after_header_wrapper', 'componentz_sticky_posts', 10 );

/**
 * Content Wrapper Start
 *
 * Output content wrappers before #primary wrapper.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_content_wrappers_start() { ?>
    <main id="content" class="site-content" role="main">
        <div class="cz-container">
            <div class="cz-row"><?php
}
add_action( 'componentz/theme/content_wrappers_start', 'componentz_content_wrappers_start', 10 );

/**
 * Content Wrapper End
 *
 * Output end content wrappers after #primary wrapper.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_content_wrappers_end() { ?>
            </div><!-- .cz-row -->
        </div><!-- .cz-container -->
    </main><!-- #content --><?php
}
add_action( 'componentz/theme/content_wrappers_end', 'componentz_content_wrappers_end', 10 );

/**
 * Primary Sub Wrapper
 *
 * Open a .primary-sub-wrapper div into #primary section.
 *
 * @since 1.0.1
 * @return mixed
 */
function componentz_primary_sub_wrapper_start() { ?>
    <div class="primary-sub-wrapper"><?php
}
add_action( 'componentz/theme/before_posts_loop', 'componentz_primary_sub_wrapper_start', 10 );

/**
 * Grid Container Start
 *
 * Output grid container start wrapper for specific article content.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_grid_container_start() {
    if ( is_archive() || is_search() ) : ?>
        <div class="grid-container"><?php
    endif;
}
add_action( 'componentz/theme/before_posts_loop', 'componentz_grid_container_start', 20 );

/**
 * Grid Item Start
 *
 * Output grid item start wrapper for specific article content.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_grid_item_start() {
    if ( is_archive() || is_search() ) : ?>
        <div class="grid-item"><?php
    endif;
}
add_action( 'componentz/theme/before_article_wrapper', 'componentz_grid_item_start', 10 );

/**
 * Grid Item End
 *
 * Output grid item end wrapper for specific article content.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_grid_item_end() {
    if ( is_archive() || is_search() ) : ?>
        </div><!-- .grid-item --><?php
    endif;
}
add_action( 'componentz/theme/after_article_wrapper', 'componentz_grid_item_end', 10 );

/**
 * Grid Container End
 *
 * Output grid container end wrapper for specific article content.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_grid_container_end() {
    if ( is_archive() || is_search() ) : ?>
        </div><!-- .grid-container --><?php
    endif;
}
add_action( 'componentz/theme/after_posts_loop', 'componentz_grid_container_end', 10 );

/**
 * The Pagination
 *
 * Output the pagination on posts loop pages.
 *
 * @since 1.0.1
 * @return mixed
 */
function componentz_pagination() {
    Componentz()->blog->pagination();
}
add_action( 'componentz/theme/after_posts_loop', 'componentz_pagination', 20 );

/**
 * Sidebar Toggler
 *
 * Display sidebar show / hide toggle button.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_sidebar_toggler() { ?>
    <?php if( ! is_archive() && ! is_search() && ! is_page_template( 'templates/wide-width.php' ) && is_active_sidebar( 'componentz-sidebar' ) ) : ?>
        <button id="sidebar-toggler" class="open">
            <span class="screen-reader-text">
                <?php _e( 'Toggle Sidebar', 'componentz' ); ?>
            </span>
            <?php echo Componentz()->svg->icon( 'cz-icon-header', true ); // phpcs:ignore ?>
        </button><?php
    endif;
}
add_action( 'componentz/theme/after_posts_loop', 'componentz_sidebar_toggler', 30 );

/**
 * Primary Sub Wrapper End
 *
 * Close a .primary-sub-wrapper div into #primary section.
 *
 * @since 1.0.1
 * @return mixed
 */
function componentz_primary_sub_wrapper_end() { ?>
    </div><!-- .primary-sub-wrapper --><?php
}
add_action( 'componentz/theme/after_posts_loop', 'componentz_primary_sub_wrapper_end', 40 );

/**
 * Secondary Sub Wrapper Start
 *
 * Open a .secondary-sub-wrapper div into #secondary section.
 *
 * @since 1.0.1
 * @return mixed
 */
function componentz_secondary_sub_wrapper_start() { ?>
    <div class="secondary-sub-wrapper"><?php
}
add_action( 'componentz/theme/before_sidebar_widgets', 'componentz_secondary_sub_wrapper_start', 10 );

/**
 * Secondary Sub Wrapper End
 *
 * Close a .secondary-sub-wrapper div into #secondary section.
 *
 * @since 1.0.1
 * @return mixed
 */
function componentz_secondary_sub_wrapper_end() { ?>
    </div><!-- .secondary-sub-wrapper --><?php
}
add_action( 'componentz/theme/after_sidebar_widgets', 'componentz_secondary_sub_wrapper_end', 10 );

/**
 * Search Overlay
 *
 * Display search overlay wrapper after footer area.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_search_overlay() { ?>
    <div class="search-wrapper">
        <a id="btn-search-close" class="btn-search btn-search-close"
           aria-label="<?php esc_attr_e( "Close search form", 'componentz' ); ?>"
           role="button"
           href="#"><?php echo Componentz()->svg->icon( 'cz-icon-close' ); // phpcs:ignore ?></a>
        <form class="search-wrapper-form" action="<?php echo esc_url( home_url() ); ?>" method="get">
            <label class="screen-reader-text hidden" for="search-header"><?php esc_html_e( 'Search the website', 'componentz' ); ?></label>
            <input id="search-header" class="search-wrapper-input" name="s" type="search"
                   placeholder="<?php esc_attr_e( "search", 'componentz' ); ?>"
                   autocomplete="off"
                   autocorrect="off" autocapitalize="off" spellcheck="false"/>
            <span class="search-wrapper-info">
                <?php _e( "Hit enter to search or ESC to close", 'componentz' ); ?>
                <?php echo is_rtl() ? Componentz()->svg->icon( 'cz-icon-arrow-left' ) : Componentz()->svg->icon( 'cz-icon-arrow-right' ); // phpcs:ignore ?>
            </span>
        </form>
    </div>
    <?php
}
add_action( 'componentz/theme/after_footer_wrapper', 'componentz_search_overlay', 10 );

/**
 * Content Overlay
 *
 * Output .content-overlay wrapper after footer area.
 *
 * @since 1.0.0
 * @return mixed
 */
function componentz_content_overlay() { ?>
    <div class="content-overlay"></div><?php
}
add_action( 'componentz/theme/after_footer_wrapper', 'componentz_content_overlay', 20 );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
