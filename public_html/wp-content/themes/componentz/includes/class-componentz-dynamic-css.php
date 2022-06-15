<?php
/**
 * Dynamic CSS
 *
 * Componentz dynamic css class.
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

class Dynamic_CSS {
    
    /**
     * Initialization
     *
     * Initialize Componentz dynamic css.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public static function init() {
        $css  = '';
        
        $css .= self::header_image();
        
        return apply_filters( 'componentz/theme/dynamic_css', $css );
    }
    
    /**
     * Header Image
     *
     * Dynamic css for header image.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public static function header_image() {
        $css = '';
        
        $background = get_theme_mod( 'componentz_header_background', 'image' );
        $background = esc_attr( $background );
        $position   = get_theme_mod( 'componentz_header_background_position', 'left bottom' );
        $position   = esc_attr( $position );
        
        // Header background style = color, image-overlay.
        if( 'color' == $background || 'image-overlay' == $background ) {
            $css .= '#componentz-header > .header-background {';
            $css .= 'background: -o-linear-gradient(50deg, ';
            $css .= esc_attr( get_theme_mod( 'componentz_header_color_left', '#0d55ff' ) ) .' 0, ';
            $css .= esc_attr( get_theme_mod( 'componentz_header_color_right', '#0f99cb' ) ) . ' 100%);';
            $css .= 'background: linear-gradient(50deg, ';
            $css .= esc_attr( get_theme_mod( 'componentz_header_color_left', '#0d55ff' ) ) .' 0, ';
            $css .= esc_attr( get_theme_mod( 'componentz_header_color_right', '#0f99cb' ) ) . ' 100%);';
            $css .= '}';
        }
        
        // Header background style = image, image-overlay.
        if( 'image' == $background || 'image-overlay' == $background ) {
            $css .= '#componentz-header img.header-image {';
                switch( $position ) {
                    case 'top':
                        $css .= '-o-object-position: 50% 0; object-position: 50% 0;';
                    break;
                    case 'center':
                        $css .= '-o-object-position: 50% 50%; object-position: 50% 50%;';
                    break;
                    case 'bottom':
                        $css .= '-o-object-position: 50% 100%; object-position: 50% 100%;';
                    break;
                }
            $css .= '}';
            if( 'image' == $background ) {
                $css .= '#componentz-header > .header-background {';
                $css .= 'background: transparent;';
                $css .= '}';
            }
        }
        
        return $css;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
