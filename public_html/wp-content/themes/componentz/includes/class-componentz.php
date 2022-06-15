<?php
/**
 * Componentz Class
 *
 * Theme main class.
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

class Theme {
    
    /**
     * SVG
     *
     * SVG icons object.
     *
     * @since 1.0.0
     * @access public
     * @return object
     */
    public $svg;
    
    /**
     * Post Meta
     *
     * Post meta object.
     *
     * @since 1.0.0
     * @access public
     * @return object
     */
    public $meta;
    
    /**
     * Get
     *
     * Get option || meta object.
     *
     * @since 1.0.0
     * @access public
     * @return object
     */
    public $get;
    
    /**
     * Helper
     *
     * Helper object.
     *
     * @since 1.0.0
     * @access public
     * @return object
     */
    public $helper;
    
    /**
     * Blog
     *
     * Blog object.
     *
     * @since 1.0.0
     * @access public
     * @return object
     */
    public $blog;
    
    /**
     * Version
     *
     * Current theme version, string for cache busting purposes.
     * If dev mode set "true" the version uses uniqid() function for cache reset.
     * 
     * @since 1.0.0
     * @access private
     * @return string
     */
    private $version;
    
    /**
     * Development
     *
     * If development mode set to "true" the theme version 
     * will change to uniqid() for cache busting purposes.
     *
     * @since 1.0.0
     * @access private
     * @return bool
     */
    private $development = false;

    /**
     * Suffix
     *
     * If the development mode is set to "true" the componentz
     * theme will enqueue a non minimized styles & scripts.
     *
     * @since 1.1.2
     * @access private
     * @return string
     */
    private $suffix = '.min';

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
    public function __construct() {
        $this->get_template_parts();
        
        Ajax::get_instance();
        
        $this->svg    = SVG::get_instance();
        $this->meta   = Post_Meta::get_instance();
        $this->helper = Helper::get_instance();
        $this->get    = Get::get_instance();
        $this->blog   = Blog::get_instance();
        
    }
    
    /**
     * Template Parts
     *
     * Include theme main files.
     *
     * @since 1.0.0
     * @access private
     * @return none
     */
    private function get_template_parts() {
        get_template_part( 'includes/componentz-actions' );
        get_template_part( 'includes/class-componentz-ajax' );
        get_template_part( 'includes/class-componentz-dynamic-css' );
        get_template_part( 'includes/class-componentz-svg' );
        get_template_part( 'includes/class-componentz-page-walker' );
        get_template_part( 'includes/class-componentz-nav-walker' );
        get_template_part( 'includes/class-componentz-walker-comment' );
        get_template_part( 'includes/class-componentz-header-image' );
        get_template_part( 'includes/class-componentz-header-jumbotron' );
        get_template_part( 'includes/class-componentz-post-meta' );
        get_template_part( 'includes/class-componentz-helper' );
        get_template_part( 'includes/class-componentz-get' );
        get_template_part( 'includes/class-componentz-blog' );
        get_template_part( 'includes/class-componentz-filters' );
        get_template_part( 'includes/componentz-functions' );
        get_template_part( 'includes/admin/class-componentz-admin' );
        get_template_part( 'includes/class-componentz-compatibility' );
    }
    
    /**
     * Directory Path
     *
     * Componentz theme directory path.
     *
     * @param string $directory (optional) The actual name of directory.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function dirPath( $directory = null ) {
        if( isset( $directory ) ) {
            return wp_normalize_path( 
                get_template_directory() . '/' . esc_attr( $directory ) 
            );
        }
        return wp_normalize_path( 
            get_template_directory() . '/' 
        );
    }
    
    /**
     * Directory URI Path
     *
     * Componentz theme directory uri path.
     *
     * @param string $directory (optional) The actual name of directory.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function uriPath( $directory = null ) {
        if( isset( $directory ) ) {
            return esc_url( get_template_directory_uri() ) . '/' . esc_attr( $directory );
        }
        return esc_url( get_template_directory_uri() ) . '/';
    }
    
    /**
     * Development
     *
     * Return componentz theme development mode status.
     *
     * @since 1.0.8
     * @access public
     * @return bool
     */
    public function development() {
        return esc_attr( $this->development );
    }
    
    /**
     * Suffix
     *
     * Generate the ".min" suffix for the styles and scripts.
     * Depends on the development mode status.
     *
     * @since 1.1.2
     * @access public
     * @return string
     */
    public function suffix() {
        if( $this->development ) {
            $this->suffix = '';
        }
        return esc_attr( $this->suffix );
    }

    /**
     * Version
     *
     * Return componentz theme version.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function version() {
        $componentz = wp_get_theme();
        
        if( $this->development ) {
            $this->version = esc_attr( uniqid() );
        } else {
            $this->version = $componentz->get( 'Version' );
        }
        
        return $this->version;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
