<?php
/**
* Theme Functions
*
* @package Simple Writer WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

/**
* Layout Functions
*/

function simple_writer_hide_footer_widgets() {
    $hide_footer_widgets = FALSE;

    if ( simple_writer_get_option('hide_footer_widgets') ) {
        $hide_footer_widgets = TRUE;
    }

    return apply_filters( 'simple_writer_hide_footer_widgets', $hide_footer_widgets );
}

function simple_writer_is_header_social_buttons_active() {
    $social_buttons_active = TRUE;

    if ( simple_writer_get_option('hide_header_social_buttons') ) {
        $social_buttons_active = FALSE;
    }

    return apply_filters( 'simple_writer_is_header_social_buttons_active', $social_buttons_active );
}

function simple_writer_is_primary_menu_active() {
    $primary_menu_active = TRUE;

    if ( simple_writer_get_option('disable_primary_menu') ) {
        $primary_menu_active = FALSE;
    }

    return apply_filters( 'simple_writer_is_primary_menu_active', $primary_menu_active );
}

function simple_writer_is_header_content_active() {
    $header_content_active = TRUE;

    if ( simple_writer_get_option('hide_header_content') ) {
        $header_content_active = FALSE;
    }

    return apply_filters( 'simple_writer_is_header_content_active', $header_content_active );
}

function simple_writer_is_sticky_menu_active() {
    $sticky_menu_active = TRUE;

    if ( simple_writer_get_option('disable_sticky_menu') ) {
        $sticky_menu_active = FALSE;
    }

    return apply_filters( 'simple_writer_is_sticky_menu_active', $sticky_menu_active );
}

function simple_writer_is_sticky_mobile_menu_active() {
    $sticky_mobile_menu_active = FALSE;

    if ( simple_writer_get_option('enable_sticky_mobile_menu') ) {
        $sticky_mobile_menu_active = TRUE;
    }

    return apply_filters( 'simple_writer_is_sticky_mobile_menu_active', $sticky_mobile_menu_active );
}

function simple_writer_is_primary_menu_centered() {
    $center_primary_menu = FALSE;

    if ( simple_writer_get_option('center_primary_menu') ) {
        $center_primary_menu = TRUE;
    }

    return apply_filters( 'simple_writer_is_primary_menu_centered', $center_primary_menu );
}

function simple_writer_is_fitvids_active() {
    $fitvids_active = TRUE;

    if ( simple_writer_get_option('disable_fitvids') ) {
        $fitvids_active = FALSE;
    }

    return apply_filters( 'simple_writer_is_fitvids_active', $fitvids_active );
}

function simple_writer_is_backtotop_active() {
    $backtotop_active = TRUE;

    if ( simple_writer_get_option('disable_backtotop') ) {
        $backtotop_active = FALSE;
    }

    return apply_filters( 'simple_writer_is_backtotop_active', $backtotop_active );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function simple_writer_content_width() {
    $content_width = 760;

    if ( is_page_template( array( 'template-full-width-page.php', 'template-full-width-post.php' ) ) ) {
       $content_width = 1128;
    }

    if ( is_404() ) {
        $content_width = 1128;
    }

    $GLOBALS['content_width'] = apply_filters( 'simple_writer_content_width', $content_width ); /* phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound */
}
add_action( 'template_redirect', 'simple_writer_content_width', 0 );


/**
* Enqueue scripts and styles
*/

function simple_writer_scripts() {
    wp_enqueue_style('simple-writer-maincss', get_stylesheet_uri(), array(), NULL);
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/all.min.css', array(), NULL );
    wp_enqueue_style('simple-writer-webfont', '//fonts.googleapis.com/css?family=Pridi:400,700|Oswald:400,700|Merriweather:400,400i,700,700i|Frank+Ruhl+Libre:400,700&amp;display=swap', array(), NULL);

    $simple_writer_primary_menu_active = FALSE;
    if ( simple_writer_is_primary_menu_active() ) {
        $simple_writer_primary_menu_active = TRUE;
    }

    $simple_writer_sticky_menu_active = FALSE;
    $simple_writer_sticky_mobile_menu_active = FALSE;
    if ( simple_writer_is_sticky_menu_active() ) {
        $simple_writer_sticky_menu_active = TRUE;
    }
    if ( simple_writer_is_sticky_mobile_menu_active() ) {
        $simple_writer_sticky_mobile_menu_active = TRUE;
    }

    $simple_writer_sticky_sidebar_active = TRUE;
    if ( is_page_template( array( 'template-full-width-page.php', 'template-full-width-post.php' ) ) ) {
        $simple_writer_sticky_sidebar_active = FALSE;
    }
    if ( is_404() ) {
        $simple_writer_sticky_sidebar_active = FALSE;
    }
    if ( $simple_writer_sticky_sidebar_active ) {
        wp_enqueue_script('ResizeSensor', get_template_directory_uri() .'/assets/js/ResizeSensor.min.js', array( 'jquery' ), NULL, true);
        wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() .'/assets/js/theia-sticky-sidebar.min.js', array( 'jquery' ), NULL, true);
    }

    $simple_writer_fitvids_active = FALSE;
    if ( simple_writer_is_fitvids_active() ) {
        $simple_writer_fitvids_active = TRUE;
    }
    if ( $simple_writer_fitvids_active ) {
        wp_enqueue_script('fitvids', get_template_directory_uri() .'/assets/js/jquery.fitvids.min.js', array( 'jquery' ), NULL, true);
    }

    $simple_writer_backtotop_active = FALSE;
    if ( simple_writer_is_backtotop_active() ) {
        $simple_writer_backtotop_active = TRUE;
    }

    wp_enqueue_script('simple-writer-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), NULL, true );
    wp_enqueue_script('simple-writer-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), NULL, true );
    wp_enqueue_script('simple-writer-customjs', get_template_directory_uri() .'/assets/js/custom.js', array( 'jquery', 'imagesloaded' ), NULL, true);
    wp_localize_script( 'simple-writer-customjs', 'simple_writer_ajax_object',
        array(
            'ajaxurl' => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
            'primary_menu_active' => $simple_writer_primary_menu_active,
            'sticky_menu_active' => $simple_writer_sticky_menu_active,
            'sticky_mobile_menu_active' => $simple_writer_sticky_mobile_menu_active,
            'sticky_sidebar_active' => $simple_writer_sticky_sidebar_active,
            'fitvids_active' => $simple_writer_fitvids_active,
            'backtotop_active' => $simple_writer_backtotop_active,
        )
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script('simple-writer-html5shiv-js', get_template_directory_uri() .'/assets/js/html5shiv.js', array('jquery'), NULL, true);

    wp_localize_script('simple-writer-html5shiv-js','simple_writer_custom_script_vars',array(
        'elements_name' => esc_html__('abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video', 'simple-writer'),
    ));
}
add_action( 'wp_enqueue_scripts', 'simple_writer_scripts' );

/**
 * Enqueue IE compatible scripts and styles.
 */
function simple_writer_ie_scripts() {
    wp_enqueue_script( 'respond', get_template_directory_uri(). '/assets/js/respond.min.js', array(), NULL, false );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'simple_writer_ie_scripts' );

/**
 * Enqueue customizer styles.
 */
function simple_writer_enqueue_customizer_styles() {
    wp_enqueue_style( 'simple-writer-customizer-styles', get_template_directory_uri() . '/assets/css/customizer-style.css', array(), NULL );
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/all.min.css', array(), NULL );
}
add_action( 'customize_controls_enqueue_scripts', 'simple_writer_enqueue_customizer_styles' );


/**
* Register widget area.
*
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*/

function simple_writer_widgets_init() {

register_sidebar(array(
    'id' => 'simple-writer-sidebar',
    'name' => esc_html__( 'Sidebar Widgets (Everywhere)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located on the sidebar of your website. Widgets of this widget area are displayed on every page of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-side-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-home-sidebar',
    'name' => esc_html__( 'Sidebar Widgets (Default HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located on the sidebar of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-side-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-static-home-sidebar',
    'name' => esc_html__( 'Sidebar Widgets (Static HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located on the sidebar of your website. Widgets of this widget area are displayed on the static homepage of your website (when you are using a static page as your homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-side-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));


register_sidebar(array(
    'id' => 'simple-writer-top-widgets',
    'name' => esc_html__( 'Above Content Widgets (Everywhere)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located at the top of the main content of your website. Widgets of this widget area are displayed on every page of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-home-top-widgets',
    'name' => esc_html__( 'Above Content Widgets (Default HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located at the top of the main content of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-static-home-top-widgets',
    'name' => esc_html__( 'Above Content Widgets (Static HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located at the top of the main content of your website. Widgets of this widget area are displayed on the static homepage of your website (when you are using a static page as your homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));


register_sidebar(array(
    'id' => 'simple-writer-bottom-widgets',
    'name' => esc_html__( 'Below Content Widgets (Everywhere)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located at the bottom of the main content of your website. Widgets of this widget area are displayed on every page of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-home-bottom-widgets',
    'name' => esc_html__( 'Below Content Widgets (Default HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located at the bottom of the main content of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-static-home-bottom-widgets',
    'name' => esc_html__( 'Below Content Widgets (Static HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located at the bottom of the main content of your website. Widgets of this widget area are displayed on the static homepage of your website (when you are using a static page as your homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));


register_sidebar(array(
    'id' => 'simple-writer-fullwidth-widgets',
    'name' => esc_html__( 'Top Full Width Widgets (Everywhere)', 'simple-writer' ),
    'description' => esc_html__( 'This full-width widget area is located after the primary menu of your website. Widgets of this widget area are displayed on every page of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget simple-writer-top-fullwidth-widget simple-writer-widget-block widget %2$s"><div class="simple-writer-top-fullwidth-widget-inside simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-home-fullwidth-widgets',
    'name' => esc_html__( 'Top Full Width Widgets (Default HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This full-width widget area is located after the primary menu of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget simple-writer-top-fullwidth-widget simple-writer-widget-block widget %2$s"><div class="simple-writer-top-fullwidth-widget-inside simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-static-home-fullwidth-widgets',
    'name' => esc_html__( 'Top Full Width Widgets (Static HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This full-width widget area is located after the primary menu of your website. Widgets of this widget area are displayed on the static homepage of your website (when you are using a static page as your homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget simple-writer-top-fullwidth-widget simple-writer-widget-block widget %2$s"><div class="simple-writer-top-fullwidth-widget-inside simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));


register_sidebar(array(
    'id' => 'simple-writer-fullwidth-bottom-widgets',
    'name' => esc_html__( 'Bottom Full Width Widgets (Everywhere)', 'simple-writer' ),
    'description' => esc_html__( 'This full-width widget area is located before the footer of your website. Widgets of this widget area are displayed on every page of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget simple-writer-bottom-fullwidth-widget simple-writer-widget-block widget %2$s"><div class="simple-writer-bottom-fullwidth-widget-inside simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-home-fullwidth-bottom-widgets',
    'name' => esc_html__( 'Bottom Full Width Widgets (Default HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This full-width widget area is located before the footer of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget simple-writer-bottom-fullwidth-widget simple-writer-widget-block widget %2$s"><div class="simple-writer-bottom-fullwidth-widget-inside simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'simple-writer-static-home-fullwidth-bottom-widgets',
    'name' => esc_html__( 'Bottom Full Width Widgets (Static HomePage)', 'simple-writer' ),
    'description' => esc_html__( 'This full-width widget area is located before the footer of your website. Widgets of this widget area are displayed on the static homepage of your website (when you are using a static page as your homepage).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget simple-writer-bottom-fullwidth-widget simple-writer-widget-block widget %2$s"><div class="simple-writer-bottom-fullwidth-widget-inside simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));


register_sidebar(array(
    'id' => 'simple-writer-single-post-bottom-widgets',
    'name' => esc_html__( 'Single Post Bottom Widgets', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located at the bottom of single post of any post type (except attachments and pages).', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));


register_sidebar(array(
    'id' => 'simple-writer-top-footer',
    'name' => esc_html__( 'Footer Top', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located on the top of the footer of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'simple-writer-footer-1',
    'name' => esc_html__( 'Footer 1', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is the column 1 of the footer of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'simple-writer-footer-2',
    'name' => esc_html__( 'Footer 2', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is the column 2 of the footer of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'simple-writer-footer-3',
    'name' => esc_html__( 'Footer 3', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is the column 3 of the footer of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'simple-writer-footer-4',
    'name' => esc_html__( 'Footer 4', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is the column 4 of the footer of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'simple-writer-bottom-footer',
    'name' => esc_html__( 'Footer Bottom', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located on the bottom of the footer of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'simple-writer-404-widgets',
    'name' => esc_html__( '404 Page Widgets', 'simple-writer' ),
    'description' => esc_html__( 'This widget area is located on the 404(not found) page of your website.', 'simple-writer' ),
    'before_widget' => '<div id="%1$s" class="simple-writer-main-widget widget simple-writer-widget-block %2$s"><div class="simple-writer-widget-block-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="simple-writer-widget-header"><h2 class="simple-writer-widget-title"><span class="simple-writer-widget-title-inside simple-writer-clearfix">',
    'after_title' => '</span></h2></div>'));

}
add_action( 'widgets_init', 'simple_writer_widgets_init' );


function simple_writer_sidebar_one_widgets() {
    if ( is_front_page() && is_singular() ) {
    dynamic_sidebar( 'simple-writer-static-home-sidebar' );
    }

    if ( is_front_page() && is_home() && !is_paged() ) {
    dynamic_sidebar( 'simple-writer-home-sidebar' );
    }

    dynamic_sidebar( 'simple-writer-sidebar' );
}


function simple_writer_top_wide_widgets() { ?>

<?php if ( is_active_sidebar( 'simple-writer-static-home-fullwidth-widgets' ) || is_active_sidebar( 'simple-writer-home-fullwidth-widgets' ) || is_active_sidebar( 'simple-writer-fullwidth-widgets' ) ) : ?>
<div class="simple-writer-top-wrapper-outer simple-writer-clearfix">
<div class="simple-writer-featured-posts-area simple-writer-top-wrapper simple-writer-clearfix">
<?php if ( is_front_page() && is_singular() ) { ?>
<?php dynamic_sidebar( 'simple-writer-static-home-fullwidth-widgets' ); ?>
<?php } ?>

<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'simple-writer-home-fullwidth-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'simple-writer-fullwidth-widgets' ); ?>
</div>
</div>
<?php endif; ?>

<?php }


function simple_writer_top_widgets() { ?>

<?php if ( is_active_sidebar( 'simple-writer-static-home-top-widgets' ) || is_active_sidebar( 'simple-writer-home-top-widgets' ) || is_active_sidebar( 'simple-writer-top-widgets' ) ) : ?>
<div class="simple-writer-featured-posts-area simple-writer-featured-posts-area-top simple-writer-clearfix">
<?php if ( is_front_page() && is_singular() ) { ?>
<?php dynamic_sidebar( 'simple-writer-static-home-top-widgets' ); ?>
<?php } ?>

<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'simple-writer-home-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'simple-writer-top-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function simple_writer_bottom_widgets() { ?>

<?php if ( is_active_sidebar( 'simple-writer-static-home-bottom-widgets' ) || is_active_sidebar( 'simple-writer-home-bottom-widgets' ) || is_active_sidebar( 'simple-writer-bottom-widgets' ) ) : ?>
<div class='simple-writer-featured-posts-area simple-writer-featured-posts-area-bottom simple-writer-clearfix'>
<?php if ( is_front_page() && is_singular() ) { ?>
<?php dynamic_sidebar( 'simple-writer-static-home-bottom-widgets' ); ?>
<?php } ?>

<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'simple-writer-home-bottom-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'simple-writer-bottom-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function simple_writer_bottom_wide_widgets() { ?>

<?php if ( is_active_sidebar( 'simple-writer-static-home-fullwidth-bottom-widgets' ) || is_active_sidebar( 'simple-writer-home-fullwidth-bottom-widgets' ) || is_active_sidebar( 'simple-writer-fullwidth-bottom-widgets' ) ) : ?>
<div class="simple-writer-bottom-wrapper-outer simple-writer-clearfix">
<div class="simple-writer-featured-posts-area simple-writer-bottom-wrapper simple-writer-clearfix">
<?php if ( is_front_page() && is_singular() ) { ?>
<?php dynamic_sidebar( 'simple-writer-static-home-fullwidth-bottom-widgets' ); ?>
<?php } ?>

<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'simple-writer-home-fullwidth-bottom-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'simple-writer-fullwidth-bottom-widgets' ); ?>
</div>
</div>
<?php endif; ?>

<?php }


function simple_writer_404_widgets() { ?>

<?php if ( is_active_sidebar( 'simple-writer-404-widgets' ) ) : ?>
<div class="simple-writer-featured-posts-area simple-writer-featured-posts-area-top simple-writer-clearfix">
<?php dynamic_sidebar( 'simple-writer-404-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function simple_writer_post_bottom_widgets() {
    if ( is_active_sidebar( 'simple-writer-single-post-bottom-widgets' ) ) : ?>
        <div class="simple-writer-featured-posts-area simple-writer-clearfix">
        <?php dynamic_sidebar( 'simple-writer-single-post-bottom-widgets' ); ?>
        </div>
    <?php endif;
}


/**
* Social buttons
*/

function simple_writer_header_social_buttons() { ?>

<div class="simple-writer-header-social-icons simple-writer-clearfix">
    <?php if ( simple_writer_get_option('twitter_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('twitter_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-twitter" aria-label="<?php esc_attr_e('Twitter Button','simple-writer'); ?>"><i class="fab fa-twitter" aria-hidden="true" title="<?php esc_attr_e('Twitter','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('facebook_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('facebook_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-facebook" aria-label="<?php esc_attr_e('Facebook Button','simple-writer'); ?>"><i class="fab fa-facebook-f" aria-hidden="true" title="<?php esc_attr_e('Facebook','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('gplus_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('gplus_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-google-plus" aria-label="<?php esc_attr_e('Google Plus Button','simple-writer'); ?>"><i class="fab fa-google-plus-g" aria-hidden="true" title="<?php esc_attr_e('Google Plus','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('pinterest_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('pinterest_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-pinterest" aria-label="<?php esc_attr_e('Pinterest Button','simple-writer'); ?>"><i class="fab fa-pinterest" aria-hidden="true" title="<?php esc_attr_e('Pinterest','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('linkedin_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('linkedin_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-linkedin" aria-label="<?php esc_attr_e('Linkedin Button','simple-writer'); ?>"><i class="fab fa-linkedin-in" aria-hidden="true" title="<?php esc_attr_e('Linkedin','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('instagram_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('instagram_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-instagram" aria-label="<?php esc_attr_e('Instagram Button','simple-writer'); ?>"><i class="fab fa-instagram" aria-hidden="true" title="<?php esc_attr_e('Instagram','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('flickr_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('flickr_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-flickr" aria-label="<?php esc_attr_e('Flickr Button','simple-writer'); ?>"><i class="fab fa-flickr" aria-hidden="true" title="<?php esc_attr_e('Flickr','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('youtube_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('youtube_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-youtube" aria-label="<?php esc_attr_e('Youtube Button','simple-writer'); ?>"><i class="fab fa-youtube" aria-hidden="true" title="<?php esc_attr_e('Youtube','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('vimeo_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('vimeo_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-vimeo" aria-label="<?php esc_attr_e('Vimeo Button','simple-writer'); ?>"><i class="fab fa-vimeo-v" aria-hidden="true" title="<?php esc_attr_e('Vimeo','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('soundcloud_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('soundcloud_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-soundcloud" aria-label="<?php esc_attr_e('SoundCloud Button','simple-writer'); ?>"><i class="fab fa-soundcloud" aria-hidden="true" title="<?php esc_attr_e('SoundCloud','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('messenger_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('messenger_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-messenger" aria-label="<?php esc_attr_e('Messenger Button','simple-writer'); ?>"><i class="fab fa-facebook-messenger" aria-hidden="true" title="<?php esc_attr_e('Messenger','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('whatsapp_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('whatsapp_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-whatsapp" aria-label="<?php esc_attr_e('WhatsApp Button','simple-writer'); ?>"><i class="fab fa-whatsapp" aria-hidden="true" title="<?php esc_attr_e('WhatsApp','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('lastfm_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('lastfm_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-lastfm" aria-label="<?php esc_attr_e('Lastfm Button','simple-writer'); ?>"><i class="fab fa-lastfm" aria-hidden="true" title="<?php esc_attr_e('Lastfm','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('medium_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('medium_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-medium" aria-label="<?php esc_attr_e('Medium Button','simple-writer'); ?>"><i class="fab fa-medium-m" aria-hidden="true" title="<?php esc_attr_e('Medium','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('github_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('github_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-github" aria-label="<?php esc_attr_e('Github Button','simple-writer'); ?>"><i class="fab fa-github" aria-hidden="true" title="<?php esc_attr_e('Github','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('bitbucket_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('bitbucket_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-bitbucket" aria-label="<?php esc_attr_e('Bitbucket Button','simple-writer'); ?>"><i class="fab fa-bitbucket" aria-hidden="true" title="<?php esc_attr_e('Bitbucket','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('tumblr_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('tumblr_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-tumblr" aria-label="<?php esc_attr_e('Tumblr Button','simple-writer'); ?>"><i class="fab fa-tumblr" aria-hidden="true" title="<?php esc_attr_e('Tumblr','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('digg_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('digg_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-digg" aria-label="<?php esc_attr_e('Digg Button','simple-writer'); ?>"><i class="fab fa-digg" aria-hidden="true" title="<?php esc_attr_e('Digg','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('delicious_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('delicious_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-delicious" aria-label="<?php esc_attr_e('Delicious Button','simple-writer'); ?>"><i class="fab fa-delicious" aria-hidden="true" title="<?php esc_attr_e('Delicious','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('stumble_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('stumble_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-stumbleupon" aria-label="<?php esc_attr_e('Stumbleupon Button','simple-writer'); ?>"><i class="fab fa-stumbleupon" aria-hidden="true" title="<?php esc_attr_e('Stumbleupon','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('mix_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('mix_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-mix" aria-label="<?php esc_attr_e('Mix Button','simple-writer'); ?>"><i class="fab fa-mix" aria-hidden="true" title="<?php esc_attr_e('Mix','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('reddit_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('reddit_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-reddit" aria-label="<?php esc_attr_e('Reddit Button','simple-writer'); ?>"><i class="fab fa-reddit" aria-hidden="true" title="<?php esc_attr_e('Reddit','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('dribbble_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('dribbble_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-dribbble" aria-label="<?php esc_attr_e('Dribbble Button','simple-writer'); ?>"><i class="fab fa-dribbble" aria-hidden="true" title="<?php esc_attr_e('Dribbble','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('flipboard_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('flipboard_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-flipboard" aria-label="<?php esc_attr_e('Flipboard Button','simple-writer'); ?>"><i class="fab fa-flipboard" aria-hidden="true" title="<?php esc_attr_e('Flipboard','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('blogger_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('blogger_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-blogger" aria-label="<?php esc_attr_e('Blogger Button','simple-writer'); ?>"><i class="fab fa-blogger" aria-hidden="true" title="<?php esc_attr_e('Blogger','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('etsy_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('etsy_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-etsy" aria-label="<?php esc_attr_e('Etsy Button','simple-writer'); ?>"><i class="fab fa-etsy" aria-hidden="true" title="<?php esc_attr_e('Etsy','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('behance_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('behance_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-behance" aria-label="<?php esc_attr_e('Behance Button','simple-writer'); ?>"><i class="fab fa-behance" aria-hidden="true" title="<?php esc_attr_e('Behance','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('amazon_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('amazon_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-amazon" aria-label="<?php esc_attr_e('Amazon Button','simple-writer'); ?>"><i class="fab fa-amazon" aria-hidden="true" title="<?php esc_attr_e('Amazon','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('meetup_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('meetup_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-meetup" aria-label="<?php esc_attr_e('Meetup Button','simple-writer'); ?>"><i class="fab fa-meetup" aria-hidden="true" title="<?php esc_attr_e('Meetup','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('mixcloud_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('mixcloud_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-mixcloud" aria-label="<?php esc_attr_e('Mixcloud Button','simple-writer'); ?>"><i class="fab fa-mixcloud" aria-hidden="true" title="<?php esc_attr_e('Mixcloud','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('slack_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('slack_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-slack" aria-label="<?php esc_attr_e('Slack Button','simple-writer'); ?>"><i class="fab fa-slack" aria-hidden="true" title="<?php esc_attr_e('Slack','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('snapchat_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('snapchat_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-snapchat" aria-label="<?php esc_attr_e('Snapchat Button','simple-writer'); ?>"><i class="fab fa-snapchat" aria-hidden="true" title="<?php esc_attr_e('Snapchat','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('spotify_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('spotify_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-spotify" aria-label="<?php esc_attr_e('Spotify Button','simple-writer'); ?>"><i class="fab fa-spotify" aria-hidden="true" title="<?php esc_attr_e('Spotify','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('yelp_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('yelp_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-yelp" aria-label="<?php esc_attr_e('Yelp Button','simple-writer'); ?>"><i class="fab fa-yelp" aria-hidden="true" title="<?php esc_attr_e('Yelp','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('wordpress_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('wordpress_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-wordpress" aria-label="<?php esc_attr_e('WordPress Button','simple-writer'); ?>"><i class="fab fa-wordpress" aria-hidden="true" title="<?php esc_attr_e('WordPress','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('twitch_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('twitch_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-twitch" aria-label="<?php esc_attr_e('Twitch Button','simple-writer'); ?>"><i class="fab fa-twitch" aria-hidden="true" title="<?php esc_attr_e('Twitch','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('telegram_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('telegram_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-telegram" aria-label="<?php esc_attr_e('Telegram Button','simple-writer'); ?>"><i class="fab fa-telegram" aria-hidden="true" title="<?php esc_attr_e('Telegram','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('bandcamp_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('bandcamp_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-bandcamp" aria-label="<?php esc_attr_e('Bandcamp Button','simple-writer'); ?>"><i class="fab fa-bandcamp" aria-hidden="true" title="<?php esc_attr_e('Bandcamp','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('quora_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('quora_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-quora" aria-label="<?php esc_attr_e('Quora Button','simple-writer'); ?>"><i class="fab fa-quora" aria-hidden="true" title="<?php esc_attr_e('Quora','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('foursquare_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('foursquare_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-foursquare" aria-label="<?php esc_attr_e('Foursquare Button','simple-writer'); ?>"><i class="fab fa-foursquare" aria-hidden="true" title="<?php esc_attr_e('Foursquare','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('deviantart_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('deviantart_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-deviantart" aria-label="<?php esc_attr_e('DeviantArt Button','simple-writer'); ?>"><i class="fab fa-deviantart" aria-hidden="true" title="<?php esc_attr_e('DeviantArt','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('imdb_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('imdb_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-imdb" aria-label="<?php esc_attr_e('IMDB Button','simple-writer'); ?>"><i class="fab fa-imdb" aria-hidden="true" title="<?php esc_attr_e('IMDB','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('vk_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('vk_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-vk" aria-label="<?php esc_attr_e('VK Button','simple-writer'); ?>"><i class="fab fa-vk" aria-hidden="true" title="<?php esc_attr_e('VK','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('codepen_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('codepen_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-codepen" aria-label="<?php esc_attr_e('Codepen Button','simple-writer'); ?>"><i class="fab fa-codepen" aria-hidden="true" title="<?php esc_attr_e('Codepen','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('jsfiddle_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('jsfiddle_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-jsfiddle" aria-label="<?php esc_attr_e('JSFiddle Button','simple-writer'); ?>"><i class="fab fa-jsfiddle" aria-hidden="true" title="<?php esc_attr_e('JSFiddle','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('stackoverflow_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('stackoverflow_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-stackoverflow" aria-label="<?php esc_attr_e('Stack Overflow Button','simple-writer'); ?>"><i class="fab fa-stack-overflow" aria-hidden="true" title="<?php esc_attr_e('Stack Overflow','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('stackexchange_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('stackexchange_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-stackexchange" aria-label="<?php esc_attr_e('Stack Exchange Button','simple-writer'); ?>"><i class="fab fa-stack-exchange" aria-hidden="true" title="<?php esc_attr_e('Stack Exchange','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('bsa_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('bsa_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-buysellads" aria-label="<?php esc_attr_e('BuySellAds Button','simple-writer'); ?>"><i class="fab fa-buysellads" aria-hidden="true" title="<?php esc_attr_e('BuySellAds','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('web500px_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('web500px_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-web500px" aria-label="<?php esc_attr_e('500px Button','simple-writer'); ?>"><i class="fab fa-500px" aria-hidden="true" title="<?php esc_attr_e('500px','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('ello_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('ello_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-ello" aria-label="<?php esc_attr_e('Ello Button','simple-writer'); ?>"><i class="fab fa-ello" aria-hidden="true" title="<?php esc_attr_e('Ello','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('goodreads_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('goodreads_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-goodreads" aria-label="<?php esc_attr_e('Goodreads Button','simple-writer'); ?>"><i class="fab fa-goodreads" aria-hidden="true" title="<?php esc_attr_e('Goodreads','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('odnoklassniki_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('odnoklassniki_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-odnoklassniki" aria-label="<?php esc_attr_e('Odnoklassniki Button','simple-writer'); ?>"><i class="fab fa-odnoklassniki" aria-hidden="true" title="<?php esc_attr_e('Odnoklassniki','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('houzz_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('houzz_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-houzz" aria-label="<?php esc_attr_e('Houzz Button','simple-writer'); ?>"><i class="fab fa-houzz" aria-hidden="true" title="<?php esc_attr_e('Houzz','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('pocket_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('pocket_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-pocket" aria-label="<?php esc_attr_e('Pocket Button','simple-writer'); ?>"><i class="fab fa-get-pocket" aria-hidden="true" title="<?php esc_attr_e('Pocket','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('xing_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('xing_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-xing" aria-label="<?php esc_attr_e('XING Button','simple-writer'); ?>"><i class="fab fa-xing" aria-hidden="true" title="<?php esc_attr_e('XING','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('googleplay_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('googleplay_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-googleplay" aria-label="<?php esc_attr_e('Google Play Button','simple-writer'); ?>"><i class="fab fa-google-play" aria-hidden="true" title="<?php esc_attr_e('Google Play','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('slideshare_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('slideshare_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-slideshare" aria-label="<?php esc_attr_e('SlideShare Button','simple-writer'); ?>"><i class="fab fa-slideshare" aria-hidden="true" title="<?php esc_attr_e('SlideShare','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('dropbox_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('dropbox_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-dropbox" aria-label="<?php esc_attr_e('Dropbox Button','simple-writer'); ?>"><i class="fab fa-dropbox" aria-hidden="true" title="<?php esc_attr_e('Dropbox','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('paypal_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('paypal_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-paypal" aria-label="<?php esc_attr_e('PayPal Button','simple-writer'); ?>"><i class="fab fa-paypal" aria-hidden="true" title="<?php esc_attr_e('PayPal','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('viadeo_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('viadeo_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-viadeo" aria-label="<?php esc_attr_e('Viadeo Button','simple-writer'); ?>"><i class="fab fa-viadeo" aria-hidden="true" title="<?php esc_attr_e('Viadeo','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('wikipedia_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('wikipedia_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-wikipedia" aria-label="<?php esc_attr_e('Wikipedia Button','simple-writer'); ?>"><i class="fab fa-wikipedia-w" aria-hidden="true" title="<?php esc_attr_e('Wikipedia','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('skype_button') ) : ?>
            <a href="skype:<?php echo esc_html( simple_writer_get_option('skype_button') ); ?>?chat" class="simple-writer-social-icon-skype" aria-label="<?php esc_attr_e('Skype Button','simple-writer'); ?>"><i class="fab fa-skype" aria-hidden="true" title="<?php esc_attr_e('Skype','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('email_button') ) : ?>
            <a href="mailto:<?php echo esc_html( simple_writer_get_option('email_button') ); ?>" class="simple-writer-social-icon-email" aria-label="<?php esc_attr_e('Email Us Button','simple-writer'); ?>"><i class="far fa-envelope" aria-hidden="true" title="<?php esc_attr_e('Email Us','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('rss_button') ) : ?>
            <a href="<?php echo esc_url( simple_writer_get_option('rss_button') ); ?>" target="_blank" rel="nofollow" class="simple-writer-social-icon-rss" aria-label="<?php esc_attr_e('RSS Button','simple-writer'); ?>"><i class="fas fa-rss" aria-hidden="true" title="<?php esc_attr_e('RSS','simple-writer'); ?>"></i></a><?php endif; ?>
    <?php if ( simple_writer_get_option('show_header_login_button') ) { ?><?php if (is_user_logged_in()) : ?><a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Logout Button', 'simple-writer' ); ?>" class="simple-writer-social-icon-login"><i class="fas fa-sign-out-alt" aria-hidden="true" title="<?php esc_attr_e('Logout','simple-writer'); ?>"></i></a><?php else : ?><a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Login / Register Button', 'simple-writer' ); ?>" class="simple-writer-social-icon-login"><i class="fas fa-sign-in-alt" aria-hidden="true" title="<?php esc_attr_e('Login / Register','simple-writer'); ?>"></i></a><?php endif;?><?php } ?>
    <?php if ( !(simple_writer_get_option('hide_header_search_button')) ) { ?><a href="<?php echo esc_url( '#' ); ?>" aria-label="<?php esc_attr_e('Search Button','simple-writer'); ?>" class="simple-writer-social-icon-search"><i class="fas fa-search" aria-hidden="true" title="<?php esc_attr_e('Search','simple-writer'); ?>"></i></a><?php } ?>
</div>

<?php }


/**
* Author bio box
*/
function simple_writer_add_author_bio_box() {
    $content='';
    if (is_single()) {
        $content .= '
            <div class="simple-writer-author-bio">
            <div class="simple-writer-author-bio-inside">
            <div class="simple-writer-author-bio-top">
            <span class="simple-writer-author-bio-gravatar">
                '. get_avatar( get_the_author_meta('email') , 80 ) .'
            </span>
            <div class="simple-writer-author-bio-text">
                <div class="simple-writer-author-bio-name">'.esc_html__( 'Author: ', 'simple-writer' ).'<span>'. get_the_author_link() .'</span></div><div class="simple-writer-author-bio-text-description">'. wp_kses_post( get_the_author_meta('description',get_query_var('author') ) ) .'</div>
            </div>
            </div>
            </div>
            </div>
        ';
    }
    return apply_filters( 'simple_writer_add_author_bio_box', $content );
}


/**
* Post meta functions
*/

function simple_writer_post_author_text() {
    if ( simple_writer_is_option_set('post_author_text') ) {
        $post_author_text = simple_writer_get_option('post_author_text');
    } else {
        $post_author_text = esc_html__( 'Posted by', 'simple-writer' );
    }
    return apply_filters( 'simple_writer_post_author_text', $post_author_text );
}


function simple_writer_post_date_text() {
    if ( simple_writer_is_option_set('post_date_text') ) {
        $post_date_text = simple_writer_get_option('post_date_text');
    } else {
        $post_date_text = esc_html__( 'Posted on', 'simple-writer' );
    }
    return apply_filters( 'simple_writer_post_date_text', $post_date_text );
}


function simple_writer_post_comments_text() {
    if ( simple_writer_is_option_set('post_comments_text') ) {
        $post_comments_text = simple_writer_get_option('post_comments_text');
    } else {
        $post_comments_text = '';
    }
    return apply_filters( 'simple_writer_post_comments_text', $post_comments_text );
}


function simple_writer_post_cat_links_text() {
    if ( simple_writer_is_option_set('cat_links_text') ) {
        $cat_links_text = simple_writer_get_option('cat_links_text');
    } else {
        $cat_links_text = esc_html__( 'Posted in', 'simple-writer' );
    }
    return apply_filters( 'simple_writer_post_cat_links_text', $cat_links_text );
}


function simple_writer_post_tag_links_text() {
    if ( simple_writer_is_option_set('tag_links_text') ) {
        $tag_links_text = simple_writer_get_option('tag_links_text');
    } else {
        $tag_links_text = esc_html__( 'Tagged', 'simple-writer' );
    }
    return apply_filters( 'simple_writer_post_tag_links_text', $tag_links_text );
}


if ( ! function_exists( 'simple_writer_summaryview_footer' ) ) :
 /**
  * Prints HTML with meta information for the categories, tags and comments.
  */
function simple_writer_summaryview_footer() {
    global $post; ?>
    <?php if ( (!(simple_writer_get_option('hide_post_categories_home')) && has_category()) || (!(simple_writer_get_option('hide_post_tags_home')) && has_tag()) || !(simple_writer_get_option('hide_post_edit_home')) ) { ?>
    <div class="simple-writer-summary-post-footer">
    <?php
    if ( !(simple_writer_get_option('hide_post_categories_home')) && has_category() ) {
        if ( 'post' == get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'simple-writer' ) );
            if ( $categories_list ) { ?>
                <span class="simple-writer-summary-post-cat-links simple-writer-summary-post-meta"><?php if(simple_writer_post_cat_links_text()) { ?><span class="simple-writer-summary-post-meta-text"><?php echo wp_kses_post(simple_writer_post_cat_links_text()); ?>&nbsp;</span><?php } ?><?php echo wp_kses_post( $categories_list ); ?></span>
            <?php }
        }
    }

    if ( !(simple_writer_get_option('hide_post_tags_home')) && has_tag() ) {
        if ( 'post' == get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'simple-writer' ) );
            if ( $tags_list ) { ?>
                <span class="simple-writer-summary-post-tags-links simple-writer-summary-post-meta"><?php if(simple_writer_post_tag_links_text()) { ?><span class="simple-writer-summary-post-meta-text"><?php echo wp_kses_post(simple_writer_post_tag_links_text()); ?>&nbsp;</span><?php } ?><?php echo wp_kses_post( $tags_list ); ?></span>
            <?php }
        }
    }

    if ( !(simple_writer_get_option('hide_post_edit_home')) ) {
        edit_post_link( sprintf( wp_kses( /* translators: %s: Name of current post. Only visible to screen readers */ __( 'Edit<span class="simple-writer-sr-only"> %s</span>', 'simple-writer' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ), '<span class="simple-writer-summary-post-edit-link simple-writer-summary-post-meta">', '</span>' );
    }
    ?>
    </div>
    <?php } ?>
    <?php
}
endif;


if ( ! function_exists( 'simple_writer_singleview_footer' ) ) :
 /**
  * Prints HTML with meta information for the categories, tags and comments.
  */
function simple_writer_singleview_footer() {
    global $post; ?>
    <?php if ( (!(simple_writer_get_option('hide_post_categories')) && has_category()) || (!(simple_writer_get_option('hide_post_tags')) && has_tag()) || !(simple_writer_get_option('hide_post_edit')) ) { ?>
    <div class="simple-writer-singleview-post-footer">
    <?php
    if ( !(simple_writer_get_option('hide_post_categories')) && has_category() ) {
        if ( 'post' == get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'simple-writer' ) );
            if ( $categories_list ) { ?>
                <span class="simple-writer-singleview-post-cat-links simple-writer-singleview-post-meta"><?php if(simple_writer_post_cat_links_text()) { ?><span class="simple-writer-singleview-post-cat-links-text"><?php echo wp_kses_post(simple_writer_post_cat_links_text()); ?>&nbsp;</span><?php } ?><?php echo wp_kses_post( $categories_list ); ?></span>
            <?php }
        }
    }

    if ( !(simple_writer_get_option('hide_post_tags')) && has_tag() ) {
        if ( 'post' == get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'simple-writer' ) );
            if ( $tags_list ) { ?>
                <span class="simple-writer-singleview-post-tags-links simple-writer-singleview-post-meta"><?php if(simple_writer_post_tag_links_text()) { ?><span class="simple-writer-singleview-post-tags-links-text"><?php echo wp_kses_post(simple_writer_post_tag_links_text()); ?>&nbsp;</span><?php } ?><?php echo wp_kses_post( $tags_list ); ?></span>
            <?php }
        }
    }

    if ( !(simple_writer_get_option('hide_post_edit')) ) {
        edit_post_link( sprintf( wp_kses( /* translators: %s: Name of current post. Only visible to screen readers */ __( 'Edit<span class="simple-writer-sr-only"> %s</span>', 'simple-writer' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ), '<span class="simple-writer-singleview-post-edit-link simple-writer-singleview-post-meta">', '</span>' );
    }
    ?>
    </div>
    <?php } ?>
    <?php
}
endif;


function simple_writer_author_image_size() {
    global $post;
    $gravatar_size = 32;
    return apply_filters( 'simple_writer_author_image_size', $gravatar_size );
}


if ( ! function_exists( 'simple_writer_author_image' ) ) :
function simple_writer_author_image( $size = '' ) {
    global $post;
    if ( $size ) {
        $gravatar_size = $size;
    } else {
        $gravatar_size = simple_writer_author_image_size();
    }
    $author_email   = get_the_author_meta( 'user_email' );
    $gravatar_args  = apply_filters(
        'simple_writer_gravatar_args',
        array(
            'size' => $gravatar_size,
        )
    );

    $avatar_url = '';
    if( get_the_author_meta('themesdna_userprofile_image',get_query_var('author') ) ) {
        $avatar_url = get_the_author_meta( 'themesdna_userprofile_image' );
    } else {
        $avatar_url = get_avatar_url( $author_email, $gravatar_args );
    }

    //$avatar_url     = get_avatar_url( $author_email, $gravatar_args );
    if ( simple_writer_get_option('author_image_link') ) {
        $avatar_markup  = '<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" title="'.esc_attr( get_the_author() ).'"><img class="simple-writer-summary-post-author-image" alt="' . esc_attr( get_the_author() ) . '" src="' . esc_url( $avatar_url ) . '" /></a>';
    } else {
        $avatar_markup  = '<img class="simple-writer-summary-post-author-image" alt="' . esc_attr( get_the_author() ) . '" src="' . esc_url( $avatar_url ) . '" />';
    }
    return apply_filters( 'simple_writer_author_image', $avatar_markup );
}
endif;


if ( ! function_exists( 'simple_writer_summaryview_postmeta' ) ) :
function simple_writer_summaryview_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(simple_writer_get_option('hide_post_author_home')) || !(simple_writer_get_option('hide_posted_date_home')) || (!(simple_writer_get_option('hide_comments_link_home')) && ! post_password_required() && ( comments_open() || get_comments_number() )) ) { ?>
    <div class="simple-writer-summary-post-header">
    <?php if ( !(simple_writer_get_option('hide_post_author_home')) ) { ?><span class="simple-writer-summary-post-author simple-writer-summary-post-meta"><?php if(simple_writer_post_author_text()) { ?><span class="simple-writer-summary-post-meta-text"><?php echo wp_kses_post(simple_writer_post_author_text()); ?>&nbsp;</span><?php } ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span><?php } ?>
    <?php if ( !(simple_writer_get_option('hide_posted_date_home')) ) { ?><span class="simple-writer-summary-post-date simple-writer-summary-post-meta"><?php if(simple_writer_post_date_text()) { ?><span class="simple-writer-summary-post-meta-text"><?php echo wp_kses_post(simple_writer_post_date_text()); ?>&nbsp;</span><?php } ?><?php echo esc_html(get_the_date()); ?></span><?php } ?>
    <?php if ( !(simple_writer_get_option('hide_comments_link_home')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="simple-writer-summary-post-comment simple-writer-summary-post-meta"><?php if(simple_writer_post_comments_text()) { ?><span class="simple-writer-summary-post-meta-text"><?php echo wp_kses_post(simple_writer_post_comments_text()); ?>&nbsp;</span><?php } ?><?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( '0 Comments<span class="simple-writer-sr-only"> on %s</span>', 'simple-writer' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'simple_writer_singleview_postmeta' ) ) :
function simple_writer_singleview_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(simple_writer_get_option('hide_post_author')) || !(simple_writer_get_option('hide_posted_date')) || (!(simple_writer_get_option('hide_comments_link')) && ! post_password_required() && ( comments_open() || get_comments_number() )) ) { ?>
    <div class="simple-writer-singleview-post-header">
    <?php if ( !(simple_writer_get_option('hide_post_author')) ) { ?><span class="simple-writer-singleview-post-author simple-writer-singleview-post-meta"><?php if(simple_writer_post_author_text()) { ?><span class="simple-writer-singleview-post-meta-text"><?php echo wp_kses_post(simple_writer_post_author_text()); ?>&nbsp;</span><?php } ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span><?php } ?>
    <?php if ( !(simple_writer_get_option('hide_posted_date')) ) { ?><span class="simple-writer-singleview-post-date simple-writer-singleview-post-meta"><?php if(simple_writer_post_date_text()) { ?><span class="simple-writer-singleview-post-meta-text"><?php echo wp_kses_post(simple_writer_post_date_text()); ?>&nbsp;</span><?php } ?><?php echo esc_html(get_the_date()); ?></span><?php } ?>
    <?php if ( !(simple_writer_get_option('hide_comments_link')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="simple-writer-singleview-post-comment simple-writer-singleview-post-meta"><?php if(simple_writer_post_comments_text()) { ?><span class="simple-writer-singleview-post-meta-text"><?php echo wp_kses_post(simple_writer_post_comments_text()); ?>&nbsp;</span><?php } ?><?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( '0 Comments<span class="simple-writer-sr-only"> on %s</span>', 'simple-writer' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'simple_writer_pageview_postmeta' ) ) :
function simple_writer_pageview_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(simple_writer_get_option('hide_page_author')) || !(simple_writer_get_option('hide_page_date')) || (!(simple_writer_get_option('hide_page_comments')) && ! post_password_required() && ( comments_open() || get_comments_number() )) ) { ?>
    <div class="simple-writer-singleview-post-header">
    <?php if ( !(simple_writer_get_option('hide_page_author')) ) { ?><span class="simple-writer-singleview-post-author simple-writer-singleview-post-meta"><?php if(simple_writer_post_author_text()) { ?><span class="simple-writer-singleview-post-meta-text"><?php echo wp_kses_post(simple_writer_post_author_text()); ?>&nbsp;</span><?php } ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span><?php } ?>
    <?php if ( !(simple_writer_get_option('hide_page_date')) ) { ?><span class="simple-writer-singleview-post-date simple-writer-singleview-post-meta"><?php if(simple_writer_post_date_text()) { ?><span class="simple-writer-singleview-post-meta-text"><?php echo wp_kses_post(simple_writer_post_date_text()); ?>&nbsp;</span><?php } ?><?php echo esc_html(get_the_date()); ?></span><?php } ?>
    <?php if ( !(simple_writer_get_option('hide_page_comments')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="simple-writer-singleview-post-comment simple-writer-singleview-post-meta"><?php if(simple_writer_post_comments_text()) { ?><span class="simple-writer-singleview-post-meta-text"><?php echo wp_kses_post(simple_writer_post_comments_text()); ?>&nbsp;</span><?php } ?><?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( '0 Comments<span class="simple-writer-sr-only"> on %s</span>', 'simple-writer' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


/**
* Post Styles Functions
*/

/* Summary Post Style */
function simple_writer_summary_thumb_style() {
    $thumb_style = 'simple-writer-760w-autoh-image';
    if ( simple_writer_get_option('summary_thumb_style') ) {
        $thumb_style = simple_writer_get_option('summary_thumb_style');
    }
    return apply_filters( 'simple_writer_summary_thumb_style', $thumb_style );
}

function simple_writer_summary_no_thumb_image() {
   $thumb_style = 'simple-writer-760w-autoh-image';
    if ( simple_writer_get_option('summary_thumb_style') ) {
        $thumb_style = simple_writer_get_option('summary_thumb_style');
    }

    if($thumb_style === 'simple-writer-760w-450h-image') {
        $no_thumb_image = get_template_directory_uri() . '/assets/images/no-image-760-450.jpg';
    } elseif($thumb_style === 'simple-writer-760w-autoh-image') {
        $no_thumb_image = get_template_directory_uri() . '/assets/images/no-image-760-450.jpg';
    } else {
        $no_thumb_image = get_template_directory_uri() . '/assets/images/no-image-760-450.jpg';
    }

   return apply_filters( 'simple_writer_summary_no_thumb_image', $no_thumb_image );
}

function simple_writer_summary_thumb_style_class() {
    $thumb_style = simple_writer_summary_thumb_style();

    if($thumb_style === 'simple-writer-760w-450h-image') {
        $thumb_style_class = 'simple-writer-summary-post-thumbnail-nofloat simple-writer-760w-450h-thumbnail';
    } elseif($thumb_style === 'simple-writer-760w-autoh-image') {
        $thumb_style_class = 'simple-writer-summary-post-thumbnail-nofloat simple-writer-760w-autoh-thumbnail';
    } else {
        $thumb_style_class = 'simple-writer-summary-post-thumbnail-nofloat simple-writer-760w-autoh-thumbnail';
    }

    return apply_filters( 'simple_writer_summary_thumb_style_class', $thumb_style_class );
}

function simple_writer_post_content_type() {
    $post_content_type = 'post-snippets';
    if ( simple_writer_get_option('post_content_type') ) {
        $post_content_type = simple_writer_get_option('post_content_type');
    }
    return apply_filters( 'simple_writer_post_content_type', $post_content_type );
}


/**
* Posts navigation functions
*/

if ( ! function_exists( 'simple_writer_wp_pagenavi' ) ) :
function simple_writer_wp_pagenavi() {
    ?>
    <nav class="navigation posts-navigation simple-writer-clearfix" role="navigation">
        <?php wp_pagenavi(); ?>
    </nav><!-- .navigation -->
    <?php
}
endif;

if ( ! function_exists( 'simple_writer_posts_navigation' ) ) :
function simple_writer_posts_navigation() {
    if ( !(simple_writer_get_option('hide_posts_navigation')) ) {
        if ( function_exists( 'wp_pagenavi' ) ) {
            simple_writer_wp_pagenavi();
        } else {
            if ( simple_writer_get_option('posts_navigation_type') === 'normalnavi' ) {
                the_posts_navigation(array('prev_text' => esc_html__( 'Older posts', 'simple-writer' ), 'next_text' => esc_html__( 'Newer posts', 'simple-writer' )));
            } else {
                the_posts_pagination(array('mid_size' => 2, 'prev_text' => esc_html__( '&larr; Newer posts', 'simple-writer' ), 'next_text' => esc_html__( 'Older posts &rarr;', 'simple-writer' )));
            }
        }
    }
}
endif;

if ( ! function_exists( 'simple_writer_post_navigation' ) ) :
function simple_writer_post_navigation() {
    global $post;
    if ( !(simple_writer_get_option('hide_post_navigation')) ) {
        the_post_navigation(array('prev_text' => esc_html__( '%title &rarr;', 'simple-writer' ), 'next_text' => esc_html__( '&larr; %title', 'simple-writer' )));
    }
}
endif;


/**
* Menu Functions
*/

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a "Home" link as the first item
function simple_writer_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'simple_writer_page_menu_args' );

function simple_writer_fallback_menu() {
    wp_page_menu( array(
        'sort_column'  => 'menu_order, post_title',
        'menu_id'      => 'simple-writer-menu-primary-navigation',
        'menu_class'   => 'simple-writer-primary-nav-menu simple-writer-menu-primary',
        'container'    => 'ul',
        'echo'         => true,
        'link_before'  => '',
        'link_after'   => '',
        'before'       => '',
        'after'        => '',
        'item_spacing' => 'discard',
        'walker'       => '',
    ) );
}


/**
* Header Functions
*/

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function simple_writer_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'simple_writer_pingback_header' );

// Get custom-logo URL
function simple_writer_custom_logo() {
    if ( ! has_custom_logo() ) {return;}
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo_attributes = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $logo_src = $logo_attributes[0];
    return apply_filters( 'simple_writer_custom_logo', $logo_src );
}

// Site Title
function simple_writer_site_title() {
    if ( is_front_page() && is_home() ) { ?>
            <h1 class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_home() ) { ?>
            <h1 class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_singular() ) { ?>
            <p class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_category() ) { ?>
            <p class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_tag() ) { ?>
            <p class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_author() ) { ?>
            <p class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_archive() && !is_category() && !is_tag() && !is_author() ) { ?>
            <p class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_search() ) { ?>
            <p class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } elseif ( is_404() ) { ?>
            <p class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php } else { ?>
            <h1 class="simple-writer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(simple_writer_get_option('hide_tagline')) ) { ?><p class="simple-writer-site-description"><span><?php bloginfo( 'description' ); ?></span></p><?php } ?>
    <?php }
}

function simple_writer_header_image_destination() {
    $url = home_url( '/' );

    if ( simple_writer_get_option('header_image_destination') ) {
        $url = simple_writer_get_option('header_image_destination');
    }

    return apply_filters( 'simple_writer_header_image_destination', $url );
}

function simple_writer_header_image_markup() {
    if ( get_header_image() ) {
        if ( simple_writer_get_option('remove_header_image_link') ) {
            the_header_image_tag( array( 'class' => 'simple-writer-header-img', 'alt' => '' ) );
        } else { ?>
            <a href="<?php echo esc_url( simple_writer_header_image_destination() ); ?>" rel="home" class="simple-writer-header-img-link"><?php the_header_image_tag( array( 'class' => 'simple-writer-header-img', 'alt' => '' ) ); ?></a>
        <?php }
    }
}

function simple_writer_header_image_details() {
    $header_image_custom_title = '';
    if ( simple_writer_get_option('header_image_custom_title') ) {
        $header_image_custom_title = simple_writer_get_option('header_image_custom_title');
    }

    $header_image_custom_description = '';
    if ( simple_writer_get_option('header_image_custom_description') ) {
        $header_image_custom_description = simple_writer_get_option('header_image_custom_description');
    }

    if ( !(simple_writer_get_option('hide_header_image_details')) ) { ?>
    <div class="simple-writer-header-image-info">
    <div class="simple-writer-header-image-info-inside">
    <?php if ( $header_image_custom_title ) { ?>
        <p class="simple-writer-header-image-site-title simple-writer-header-image-block"><?php echo wp_kses_post( force_balance_tags( do_shortcode($header_image_custom_title) ) ); ?></p>
    <?php } else { ?>
        <p class="simple-writer-header-image-site-title simple-writer-header-image-block"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
    <?php } ?>

    <?php if ( $header_image_custom_description ) { ?>
        <?php if ( !(simple_writer_get_option('hide_header_image_description')) ) { ?><?php if ( $header_image_custom_description ) { ?><p class="simple-writer-header-image-site-description simple-writer-header-image-block"><?php echo wp_kses_post( force_balance_tags( do_shortcode($header_image_custom_description) ) ); ?></p><?php } ?><?php } ?>
    <?php } else { ?>
        <?php if ( !(simple_writer_get_option('hide_header_image_description')) ) { ?><p class="simple-writer-header-image-site-description simple-writer-header-image-block"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } ?>
    </div>
    </div>
    <?php }
}

function simple_writer_header_image_wrapper() {
    ?>
    <div class="simple-writer-header-image simple-writer-clearfix">
    <?php simple_writer_header_image_markup(); ?>
    <?php simple_writer_header_image_details(); ?>
    </div>
    <?php
}

function simple_writer_header_image() {
    if ( simple_writer_get_option('hide_header_image') ) { return; }
    if ( get_header_image() ) {
        simple_writer_header_image_wrapper();
    }
}

function simple_writer_is_header_content_image_active() {
    $header_content_image_active = FALSE;
    $header_image_id = 0;

    if ( simple_writer_get_option('header_content_image') ) {
        $header_image_id = simple_writer_get_option('header_content_image');
    }

    if ( $header_image_id > 0 ) {
        $header_content_image_active = TRUE;
    }

    return apply_filters( 'simple_writer_is_header_content_image_active', $header_content_image_active );
}

function simple_writer_is_footer_content_image_active() {
    $footer_content_image_active = FALSE;
    $footer_image_id = 0;

    if ( simple_writer_get_option('footer_content_image') ) {
        $footer_image_id = simple_writer_get_option('footer_content_image');
    }

    if ( $footer_image_id > 0 ) {
        $footer_content_image_active = TRUE;
    }

    return apply_filters( 'simple_writer_is_footer_content_image_active', $footer_content_image_active );
}


/**
* Css Classes Functions
*/

// Category ids in post class
function simple_writer_category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category) {
        $classes [] = 'wpcat-' . $category->cat_ID . '-id';
    }
    return $classes;
}
add_filter('post_class', 'simple_writer_category_id_class');


// Adds custom classes to the array of body classes.
function simple_writer_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'simple-writer-group-blog';
    }

    $classes[] = 'simple-writer-theme-is-active';

    if ( get_header_image() ) {
        $classes[] = 'simple-writer-header-image-active';
    }

    if ( has_custom_logo() ) {
        $classes[] = 'simple-writer-custom-logo-active';
    }

    if ( is_page_template( array( 'template-full-width-page.php', 'template-full-width-post.php' ) ) ) {
       $classes[] = 'simple-writer-layout-full-width';
    }

    if ( is_404() ) {
        $classes[] = 'simple-writer-layout-full-width';
    }

    $classes[] = 'simple-writer-header-full-width';

    if ( simple_writer_get_option('hide_tagline') ) {
        $classes[] = 'simple-writer-tagline-inactive';
    }

    if ( simple_writer_is_header_content_image_active() ) {
        $classes[] = 'simple-writer-header-content-image-active';
    }

    if ( simple_writer_is_footer_content_image_active() ) {
        $classes[] = 'simple-writer-footer-content-image-active';
    }

    if ( simple_writer_is_primary_menu_active() ) {
        $classes[] = 'simple-writer-primary-menu-active';
    }
    $classes[] = 'simple-writer-primary-mobile-menu-active';
    if ( simple_writer_is_primary_menu_centered() ) {
        $classes[] = 'simple-writer-primary-menu-centered';
    }

    $classes[] = 'simple-writer-table-css-active';

    return $classes;
}
add_filter( 'body_class', 'simple_writer_body_classes' );


/**
* More Custom Functions
*/

function simple_writer_read_more_text() {
   $readmoretext = esc_html__( 'Continue Reading', 'simple-writer' );
    if ( simple_writer_get_option('read_more_text') ) {
            $readmoretext = simple_writer_get_option('read_more_text');
    }
   return $readmoretext;
}

// Change excerpt length
function simple_writer_excerpt_length($length) {
    if ( is_admin() ) {
        return $length;
    }
    $read_more_length = 40;
    if ( simple_writer_get_option('read_more_length') ) {
        $read_more_length = simple_writer_get_option('read_more_length');
    }
    return $read_more_length;
}
add_filter('excerpt_length', 'simple_writer_excerpt_length');

// Change excerpt more word
function simple_writer_excerpt_more($more) {
    if ( is_admin() ) {
        return $more;
    }
    return '...';
}
add_filter('excerpt_more', 'simple_writer_excerpt_more');

if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     */
    function wp_body_open() { // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedFunctionFound
        /**
         * Triggered after the opening <body> tag.
         */
        do_action( 'wp_body_open' ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
    }
endif;


/**
* Custom Hooks
*/

function simple_writer_before_header() {
    do_action('simple_writer_before_header');
}

function simple_writer_after_header() {
    do_action('simple_writer_after_header');
}

function simple_writer_before_main_content() {
    do_action('simple_writer_before_main_content');
}
add_action('simple_writer_before_main_content', 'simple_writer_top_widgets', 20 );

function simple_writer_after_main_content() {
    do_action('simple_writer_after_main_content');
}
add_action('simple_writer_after_main_content', 'simple_writer_bottom_widgets', 10 );

function simple_writer_sidebar_one() {
    do_action('simple_writer_sidebar_one');
}
add_action('simple_writer_sidebar_one', 'simple_writer_sidebar_one_widgets', 10 );

function simple_writer_before_single_post() {
    do_action('simple_writer_before_single_post');
}

function simple_writer_before_single_post_title() {
    do_action('simple_writer_before_single_post_title');
}

function simple_writer_after_single_post_title() {
    do_action('simple_writer_after_single_post_title');
}

function simple_writer_after_single_post_content() {
    do_action('simple_writer_after_single_post_content');
}

function simple_writer_after_single_post() {
    do_action('simple_writer_after_single_post');
}

function simple_writer_before_single_page() {
    do_action('simple_writer_before_single_page');
}

function simple_writer_before_single_page_title() {
    do_action('simple_writer_before_single_page_title');
}

function simple_writer_after_single_page_title() {
    do_action('simple_writer_after_single_page_title');
}

function simple_writer_after_single_page_content() {
    do_action('simple_writer_after_single_page_content');
}

function simple_writer_after_single_page() {
    do_action('simple_writer_after_single_page');
}

function simple_writer_before_comments() {
    do_action('simple_writer_before_comments');
}

function simple_writer_after_comments() {
    do_action('simple_writer_after_comments');
}

function simple_writer_before_footer() {
    do_action('simple_writer_before_footer');
}

function simple_writer_after_footer() {
    do_action('simple_writer_after_footer');
}

if ( !(simple_writer_get_option('enable_widgets_block_editor')) ) {
    // Disables the block editor from managing widgets in the Gutenberg plugin.
    add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

    // Disables the block editor from managing widgets.
    add_filter( 'wp_use_widgets_block_editor', '__return_false' );
}


// Header styles
if ( ! function_exists( 'simple_writer_header_style' ) ) :
function simple_writer_header_style() {
    $header_text_color = get_header_textcolor();
    //if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) { return; }
    ?>
    <style type="text/css">
    <?php if ( ! display_header_text() ) : ?>
        .simple-writer-site-title, .simple-writer-site-description {position: absolute;clip: rect(1px, 1px, 1px, 1px);}
    <?php else : ?>
        .simple-writer-site-title, .simple-writer-site-title a, .simple-writer-site-description {color: #<?php echo esc_attr( $header_text_color ); ?>;}
    <?php endif; ?>
    </style>
    <?php
}
endif;


function simple_writer_inline_css() {
    $custom_css = '';

    if ( simple_writer_get_option('header_text_hover_color') ) {
        $header_text_hover_color = simple_writer_get_option('header_text_hover_color');
        $custom_css .= '.simple-writer-site-title a:hover,.simple-writer-site-title a:focus,.simple-writer-site-title a:active{color:'.esc_html( $header_text_hover_color ).';}';
    }

    if ( simple_writer_get_option('social_buttons_color') ) {
        $social_buttons_color = simple_writer_get_option('social_buttons_color');
        $custom_css .= '.simple-writer-header-social-icons a{color:'.esc_html( $social_buttons_color ).' !important;}';
    }
    if ( simple_writer_get_option('social_buttons_shadow_color') ) {
        $social_buttons_shadow_color = simple_writer_get_option('social_buttons_shadow_color');
        $custom_css .= '.simple-writer-header-social-icons a{text-shadow:0 1px 0 '.esc_html( $social_buttons_shadow_color ).' !important;}';
    }
    if ( simple_writer_get_option('social_buttons_hover_color') ) {
        $social_buttons_hover_color = simple_writer_get_option('social_buttons_hover_color');
        $custom_css .= '.simple-writer-header-social-icons a:hover,.simple-writer-header-social-icons a:focus,.simple-writer-header-social-icons a:active{color:'.esc_html( $social_buttons_hover_color ).' !important;}';
    }

    $header_content_bg_size = 'cover';
    if ( simple_writer_get_option('header_content_bg_size') ) {
        $header_content_bg_size = simple_writer_get_option('header_content_bg_size');
    }

    $header_content_bg_position = 'center top';
    if ( simple_writer_get_option('header_content_bg_position') ) {
        $header_content_bg_position = simple_writer_get_option('header_content_bg_position');
    }

    $header_content_bg_attachment = 'scroll';
    if ( simple_writer_get_option('header_content_bg_attachment') ) {
        $header_content_bg_attachment = simple_writer_get_option('header_content_bg_attachment');
    }

    $header_content_bg_repeat = 'no-repeat';
    if ( simple_writer_get_option('header_content_bg_repeat') ) {
        $header_content_bg_repeat = simple_writer_get_option('header_content_bg_repeat');
    }

    $header_image_id = 0;
    if ( simple_writer_get_option('header_content_image') ) {
        $header_image_id = absint(simple_writer_get_option('header_content_image'));
    }
    if ( $header_image_id > 0 ) {
        $custom_css .= '.simple-writer-head-content{background-image:url("'.esc_url( wp_get_attachment_url( $header_image_id ) ).'");background-position:'.esc_html( $header_content_bg_position ).';background-attachment:'.esc_html( $header_content_bg_attachment ).';background-repeat:'.esc_html( $header_content_bg_repeat ).';-webkit-background-size:'.esc_html( $header_content_bg_size ).';-moz-background-size:'.esc_html( $header_content_bg_size ).';-o-background-size:'.esc_html( $header_content_bg_size ).';background-size:'.esc_html( $header_content_bg_size ).';}';
    }

    $header_content_height = 0;
    if ( simple_writer_get_option('header_content_height') ) {
        $header_content_height = absint(simple_writer_get_option('header_content_height'));
    }
    if ( $header_content_height > 0 ) {
        $custom_css .= '@media only screen and (min-width: 721px) {.simple-writer-head-content{min-height:'.esc_html( $header_content_height ).'px;}}';
    }

    $header_content_height_small = 0;
    if ( simple_writer_get_option('header_content_height_small') ) {
        $header_content_height_small = absint(simple_writer_get_option('header_content_height_small'));
    }
    if ( $header_content_height_small > 0 ) {
        $custom_css .= '@media only screen and (min-width: 414px) and (max-width: 720px) {.simple-writer-head-content{min-height:'.esc_html( $header_content_height_small ).'px;}}';
    }

    $header_content_height_smaller = 0;
    if ( simple_writer_get_option('header_content_height_smaller') ) {
        $header_content_height_smaller = absint(simple_writer_get_option('header_content_height_smaller'));
    }
    if ( $header_content_height_smaller > 0 ) {
        $custom_css .= '@media only screen and (max-width: 413px) {.simple-writer-head-content{min-height:'.esc_html( $header_content_height_smaller ).'px;}}';
    }

    $header_content_padding = 0;
    if ( simple_writer_get_option('header_content_padding') ) {
        $header_content_padding = absint(simple_writer_get_option('header_content_padding'));
    }
    if ( $header_content_padding > 0 ) {
        $custom_css .= '@media only screen and (min-width: 721px) {.simple-writer-head-content{padding:'.esc_html( $header_content_padding ).'px 0;}}';
    }

    $header_content_padding_small = 0;
    if ( simple_writer_get_option('header_content_padding_small') ) {
        $header_content_padding_small = absint(simple_writer_get_option('header_content_padding_small'));
    }
    if ( $header_content_padding_small > 0 ) {
        $custom_css .= '@media only screen and (min-width: 414px) and (max-width: 720px) {.simple-writer-head-content{padding:'.esc_html( $header_content_padding_small ).'px 0;}}';
    }

    $header_content_padding_smaller = 0;
    if ( simple_writer_get_option('header_content_padding_smaller') ) {
        $header_content_padding_smaller = absint(simple_writer_get_option('header_content_padding_smaller'));
    }
    if ( $header_content_padding_smaller > 0 ) {
        $custom_css .= '@media only screen and (max-width: 413px) {.simple-writer-head-content{padding:'.esc_html( $header_content_padding_smaller ).'px 0;}}';
    }

    $footer_content_bg_size = 'cover';
    if ( simple_writer_get_option('footer_content_bg_size') ) {
        $footer_content_bg_size = simple_writer_get_option('footer_content_bg_size');
    }

    $footer_content_bg_position = 'center top';
    if ( simple_writer_get_option('footer_content_bg_position') ) {
        $footer_content_bg_position = simple_writer_get_option('footer_content_bg_position');
    }

    $footer_content_bg_attachment = 'scroll';
    if ( simple_writer_get_option('footer_content_bg_attachment') ) {
        $footer_content_bg_attachment = simple_writer_get_option('footer_content_bg_attachment');
    }

    $footer_content_bg_repeat = 'no-repeat';
    if ( simple_writer_get_option('footer_content_bg_repeat') ) {
        $footer_content_bg_repeat = simple_writer_get_option('footer_content_bg_repeat');
    }

    $footer_image_id = 0;
    if ( simple_writer_get_option('footer_content_image') ) {
        $footer_image_id = absint(simple_writer_get_option('footer_content_image'));
    }
    if ( $footer_image_id > 0 ) {
        $custom_css .= '#simple-writer-footer-blocks{background-image:url("'.esc_url( wp_get_attachment_url( $footer_image_id ) ).'");background-position:'.esc_html( $footer_content_bg_position ).';background-attachment:'.esc_html( $footer_content_bg_attachment ).';background-repeat:'.esc_html( $footer_content_bg_repeat ).';-webkit-background-size:'.esc_html( $footer_content_bg_size ).';-moz-background-size:'.esc_html( $footer_content_bg_size ).';-o-background-size:'.esc_html( $footer_content_bg_size ).';background-size:'.esc_html( $footer_content_bg_size ).';}';
    }

    if( '' != $custom_css ) {
        wp_add_inline_style( 'simple-writer-maincss', $custom_css );
    }
}
add_action( 'wp_enqueue_scripts', 'simple_writer_inline_css' );