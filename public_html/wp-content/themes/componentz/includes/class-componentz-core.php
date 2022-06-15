<?php
/**
 * Core Class
 *
 * Componentz core class is the heart of Componentz theme.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 * @since 1.0.3 Updated the code.
 */

namespace Componentz;

// Do not allow direct access.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Core {

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
        
        $this->suffix = Componentz()->suffix();
        
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on componentz, use a find and replace
         * to change 'componentz' to the name of your theme in all the template files.
         *
         * @link https://developer.wordpress.org/reference/functions/load_theme_textdomain/
         */
        load_theme_textdomain( 'componentz', Componentz()->dirPath( 'languages' ) );
        
        /**
         * Setup
         *
         * Setup the componentz theme.
         */
        add_action( 'after_setup_theme', [ $this, 'componentz_theme_support' ] );
        
        /**
         * Enqueue Styles
         *
         * Enqueue theme front-end styles.
         */
        add_action( 'wp_enqueue_scripts', [ $this, 'componentz_register_styles' ] );
        
        /**
         * Enqueue Scripts
         *
         * Enqueue theme front-end scripts.
         */
        add_action( 'wp_enqueue_scripts', [ $this, 'componentz_register_scripts' ] );
        
        /**
         * Register Widgets
         *
         * Register componentz theme widgets.
         */
        add_action( 'widgets_init', [ $this, 'componentz_sidebar_registration' ] );
        
        if( has_action( 'componentz/theme/loaded' ) ) {
            /**
             * Hook: componentz/theme/loaded
             *
             * @hooked none
             *
             * @since 1.0.0
             */
            do_action( 'componentz/theme/loaded' );
        }
    }
    
    /**
     * Theme Support
     *
     * The componentz theme support setup.
     *
     * @since 1.0.0
     * @since 1.0.2 Updated the code.
     * @access public
     * @return void
     */
    public function componentz_theme_support() {
        global $content_width;
        
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
         */
        add_theme_support( 'title-tag' );
        
        /**
         * Add default posts and comments RSS feed links to head.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#feed-links
         */
        add_theme_support( 'automatic-feed-links' );
        
        /**
         * Set content-width.
         *
         * @link https://developer.wordpress.com/themes/content-width/
         */
        if( ! isset( $content_width ) ) {
            $content_width = 990;
        }
        
        /**
         * Add support for editor styles.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#editor-styles
         */
        add_theme_support( 'editor-styles' );

        /**
         * Enqueue editor styles.
         *
         * @link https://developer.wordpress.org/reference/functions/add_editor_style/
         */
        add_editor_style( 'assets/css/editor-style.css' );

        /**
         * Add support for full and wide align images.
         *
         * https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment
         */
        add_theme_support( 'align-wide' );
        
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
         */
        add_theme_support( 'html5', [ 
            'comment-list', 
            'comment-form', 
            'search-form', 
            'gallery', 
            'caption',
            'script',
            'style'
        ] );
        
        /**
         * Enable support for custom headers.
         *
         * @link https://developer.wordpress.org/themes/functionality/custom-headers/
         */
        add_theme_support( 'custom-header', [
            'default-image'          => get_template_directory_uri() . '/assets/img/header-image.svg', // Default Header Image to display
            'width'                  => 1920,   // Header image width (in pixels)
            'height'                 => 800,    // Header image height (in pixels)
            'flex-height'            => false,  // Flex height
            'flex-width'             => false,  // Flex width
            'uploads'                => true,   // Enable upload of image file in admin 
            'random-default'         => false,  // Header image random rotation default
            'header-text'            => false,  // Display the header text along with the image
            'default-text-color'     => '',     // Header text color default
            'wp-head-callback'       => '',     // function to be called in theme head section
            'admin-head-callback'    => '',     // function to produce preview markup in the admin screen
            'admin-preview-callback' => ''      // function to be called in preview page head section
        ] );
        
        /**
         * Register a selection of default headers to be displayed by the custom header admin UI.
         *
         * @link https://developer.wordpress.org/reference/functions/register_default_headers/
         */
        register_default_headers( [
            'city' => [
                'url'           => get_template_directory_uri() . '/assets/img/header-image.svg',
                'thumbnail_url' => get_template_directory_uri() . '/assets/img/header-image.svg',
                'description'   => esc_html__( 'Header Image', 'componentz' )
            ]
        ] );

        /**
         * Register theme navigation menus.
         *
         * @link https://developer.wordpress.org/reference/functions/register_nav_menu/
         */
        register_nav_menus( [
            'componentz_primary_menu' => esc_html__( 'Primary Menu', 'componentz' ),
            'componentz_side_menu'    => esc_html__( 'Side Menu', 'componentz' )
        ] );
        
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 800, 9999 );
        
        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );
        
        /**
         * Add theme support for post-formats.
         *
         * @link https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support( 'post-formats', [ 
            'aside', 
            'image', 
            'link', 
            'quote', 
            'status' 
        ] );
       
        /**
         * Add theme support for WooCommerce.
         *
         * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
         */
        add_theme_support( 'woocommerce' );
        
        /**
         * Add theme support for WooCommerce product gallery.
         *
         * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
         */
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
    
    /**
     * Register Styles
     *
     * Register the componentz theme styles for front-end.
     *
     * @since 1.0.0
     * @since 1.0.3 Updated the code.
     * @access public
     * @return void
     */
    public function componentz_register_styles() {
        if( has_action( 'componentz/theme/before_enqueue_styles' ) ) {
            /**
             * Hook: componentz/theme/before_enqueue_styles
             *
             * @hooked none
             *
             * @since 1.0.0
             */
            do_action( 'componentz/theme/before_enqueue_styles' );
        }
        
        // If Kirki plugin not installed.
        if( ! class_exists( 'Kirki' ) ) {
            wp_enqueue_style( 'componentz-lato', 'https://fonts.googleapis.com/css?family=Lato:400,900&display=swap' );
        }

        // Bootstrap
        wp_register_style( 
            'componentz-bootstrap',
            Componentz()->uriPath( "assets/lib/bootstrap/bootstrap{$this->suffix}.css" ),
            [],
            Componentz()->version()
        );
        
        // componentz Style
        wp_enqueue_style(
            'componentz',
            get_stylesheet_uri(),
            [ 
                'componentz-bootstrap'
            ],
            Componentz()->version()
        );
        
        $suffix = '';
        if ( is_child_theme() ) {
            $suffix = '-parent';
        }

        // componentz RTL Style Support
        wp_style_add_data( 'componentz' . $suffix, 'rtl', 'replace' );
        
        // componentz Inline Style
        wp_add_inline_style( 'componentz' . $suffix, Dynamic_CSS::init() );
        
        if( has_action( 'componentz/theme/after_enqueue_styles' ) ) {
            /**
             * Hook: componentz/theme/after_enqueue_styles
             *
             * @hooked none
             *
             * @since 1.0.0
             */
            do_action( 'componentz/theme/after_enqueue_styles' );
        }
    }
    
    /**
     * Register Scripts
     *
     * Register the componentz theme scripts for front-end.
     *
     * @since 1.0.0
     * @since 1.0.3 Updated the code.
     * @access public
     * @return void
     */
    public function componentz_register_scripts() {
        if( has_action( 'componentz/theme/before_enqueue_scripts' ) ) {
            /**
             * Hook: componentz/theme/before_enqueue_scripts
             *
             * @hooked none
             *
             * @since 1.0.0
             */
            do_action( 'componentz/theme/before_enqueue_scripts' );
        }
        
        // Comment Reply
        if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
        
        // Bootstrap/*
        wp_register_script(
            'componentz-bootstrap',
            Componentz()->uriPath( "assets/lib/bootstrap/bootstrap{$this->suffix}.js" ),
            [],
            Componentz()->version(),
            true
        );
        
        // AOS
        wp_register_script(
            'componentz-aos',
            Componentz()->uriPath( "assets/lib/aos/aos{$this->suffix}.js" ),
            [],
            Componentz()->version(),
            true
        );
        
        // simpleParallax
        wp_register_script(
            'componentz-simpleparallax',
            Componentz()->uriPath( "assets/lib/simpleparallax/simpleParallax{$this->suffix}.js" ),
            [],
            Componentz()->version(),
            true
        );
        
        // jRespond
        wp_register_script(
            'componentz-jrespond',
            Componentz()->uriPath( "assets/lib/jRespond/jRespond{$this->suffix}.js" ),
            [],
            Componentz()->version(),
            true
        );
        
        // componentz Functions
        wp_enqueue_script(
            'componentz-functions',
            Componentz()->uriPath( "assets/js/functions{$this->suffix}.js#asyncload" ),
            [ 
                'jquery',
                'componentz-bootstrap', 
                'componentz-aos', 
                'componentz-simpleparallax', 
                'componentz-jrespond'
            ],
            Componentz()->version(),
            true
        );
        
        $sticky_header     = get_theme_mod( 'componentz_header_sticky', true );
        $header_search     = Componentz()->helper->is_header_right_side_active( 'search' );
        $header_background = get_theme_mod( 'componentz_header_background', 'image' );
        $preloader         = get_theme_mod( 'componentz_preloader', false );
        $is_child_theme    = is_child_theme();
        
        // Localization
        wp_localize_script( 
            'componentz-functions', 
            '_ComponentzData', 
            [
                'preloader'            => esc_attr( $preloader ),
                'sticky_header'        => esc_attr( $sticky_header ),
                'header_search'        => esc_attr( $header_search ),
                'header_background'    => esc_attr( $header_background ),
                'is_child_theme'       => esc_attr( $is_child_theme ),
                'version'              => esc_attr( Componentz()->version() )
            ]
        );
        
        if( has_action( 'componentz/theme/after_enqueue_scripts' ) ) {
            /**
             * Hook: componentz/theme/after_enqueue_scripts
             * 
             * @hooked none
             *
             * @since 1.0.0
             */
            do_action( 'componentz/theme/after_enqueue_scripts' );
        }
    }
    
    /**
     * Register Widgets
     *
     * Register widgets areas.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     *
     * @since 1.0.0
     * @since 1.0.3 Changed function name.
     * @access public
     * @return null
     */
    public function componentz_sidebar_registration() {
        $settings = esc_attr( get_theme_mod( 'componentz_footer_widgets_layout', 'six-six' ) );
        register_sidebar( [
            'id'            => 'componentz-sidebar',
            'name'          => esc_html__( 'Main Sidebar', 'componentz' ),
            'description'   => esc_html__( 'Appears on posts and pages.', 'componentz' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        if( class_exists( 'woocommerce' ) ) {
            register_sidebar( [
                'id'            => 'componentz-woocommerce-sidebar',
                'name'          => esc_html__( 'WooCommerce Sidebar', 'componentz' ),
                'description'   => esc_html__( 'Appears on WooCommerce pages.', 'componentz' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ] );
        }
        register_sidebar( [
            'id'            => 'componentz-footer-1',
            'name'          => esc_html__( 'Footer 1', 'componentz' ),
            'description'   => esc_html__( 'Appears on footer 1 area.', 'componentz' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        if( 'twelve' !== $settings ) {
            register_sidebar( [
                'id'            => 'componentz-footer-2',
                'name'          => esc_html__( 'Footer 2', 'componentz' ),
                'description'   => esc_html__( 'Appears on footer 2 area.', 'componentz' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ] );
        }
        if( 'four-four-four' == $settings || 'three-three-three-three' == $settings || 'six-three-three' == $settings ) {
            register_sidebar( [
                'id'            => 'componentz-footer-3',
                'name'          => esc_html__( 'Footer 3', 'componentz' ),
                'description'   => esc_html__( 'Appears on footer 3 area.', 'componentz' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ] );
        }
        if( 'three-three-three-three' == $settings ) {
            register_sidebar( [
                'id'            => 'componentz-footer-4',
                'name'          => esc_html__( 'Footer 4', 'componentz' ),
                'description'   => esc_html__( 'Appears on footer 4 area.', 'componentz' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ] );
        }
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
