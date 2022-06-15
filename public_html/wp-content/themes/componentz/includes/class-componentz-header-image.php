<?php
/**
 * Header Image
 *
 * Componentz theme header image class.
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

class Header_Image {
    
    /**
     * Background Style
     *
     * The header image background style.
     *
     * @since 1.0.0
     * @access private
     */
    private $background_style;
    
    /**
     * Header Image
     *
     * The header image url holder.
     *
     * @since 1.0.0
     */
    private $header_image;
    
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
        $this->background_style = esc_attr( 
            get_theme_mod( 'componentz_header_background', 'image' )
        );
        
        $this->Initialize();
    }
    
    /**
     * Initialize
     *
     * Initialize the componentz theme header image.
     *
     * @since 1.0.0
     * @since 1.1.2 Updated the code.
     * @access public
     * @retun mixed
     */
    public function Initialize() {
        $default = get_template_directory_uri() . '/assets/img/header-image.svg';
        $this->header_image = get_theme_mod( 'header_image', $default );

        // If random header image.
        if( is_random_header_image() ) {
            $this->header_image = get_random_header_image(); //phpcs: ignore
        }

        if( 'image' == $this->background_style || 'image-overlay' == $this->background_style ) {
            if( ! empty( $this->header_image ) ) { ?>
                <div class="simpleParallax">
                    <img src="<?php echo esc_url( $this->header_image ); ?>" class="header-image" alt="<?php esc_attr_e( 'Header Image', 'componentz' ); ?>">
                </div><?php
            }
        }
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
