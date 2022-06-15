<?php
/**
 * SVG Icons Class
 *
 * Componentz theme SVG icons class.
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

class SVG {
    
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
     * Icon
     *
     * Generates SVG icon on request.
     *
     * @param string $icon (required) The name of the icon.
     * @param bool $backend (optional) Load backend icons if isset "true".
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function icon( $icon, $backend = false ) {
        if( empty( $icon ) ) {
            return;
        }
        
        if( $backend ) {
            $svg  = '<svg class="cz-icon '. esc_attr( $icon ) .'" aria-hidden="true" role="img">';
            $svg .= '<use xlink:href="'. Componentz()->uriPath( 'assets/img/icons/admin.svg#' . esc_html( $icon ) ) .'"></use>';
            $svg .= '</svg>';
        } else {
            $svg  = '<svg class="cz-icon '. esc_attr( $icon ) .'" aria-hidden="true" role="img">';
            $svg .= '<use xlink:href="'. Componentz()->uriPath( 'assets/img/icons/front.svg#' . esc_html( $icon ) ) .'"></use>';
            $svg .= '</svg>';
        }
        
        return $svg;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
