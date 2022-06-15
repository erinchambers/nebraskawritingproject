<?php
/**
 * Choices
 *
 * The select choices used in customize select fields.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

namespace Componentz\Admin;

// Do not allow direct access.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Choices {
    
    /**
     * Sanitize Multidimensional Array
     *
     * Trim and filter every value in the nested array.
     *
     * @since 1.0.0
     * @access private
     * @return array
     */
    private static function sanitize_multidimensional_array( array &$array ) {
        array_walk_recursive( $array, function ( &$value ) {
            $value = filter_var( trim( $value ), FILTER_SANITIZE_STRING );
        });

        return $array;
    }
    
    /**
     * Default Fonts
     *
     * Theme defaults fonts.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function default_fonts() {
       $default = [ 'Lato' ]; // Default font.

        /**
         * Filters the list of font names.
         *
         * @param array $default (required) The list of default theme fonts.
         *
         * @since 1.0.0
         */
        $fonts = apply_filters( 'componentz/theme/default_fonts', $default );

        return $fonts;
    }
    
    /**
     * Custom Fonts
     *
     * Theme custom fonts.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function custom_fonts() {
        return [
            'fonts' => [
                'google' => self::default_fonts()
                ],
            'variant' => [ '400', '900' ]
        ];
    }
    
    /**
     * Header Styles
     *
     * The list of theme header styles.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function header_styles() {
        $headers = componentz_header_styles();
        if( is_array( $headers ) ) {
            foreach( $headers as $key => $value ) {
                $output[$key] = esc_html( $value['name'] );
            }
            return $output;
        }
    }
    
    /**
     * Logo Types
     *
     * Output logo types choice.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function logo_types() {
        $defaults = [
            'title' => __( 'Site Title', 'componentz' ),
            'logo'  => __( 'Logo', 'componentz' )
        ];
        
        /**
         * Filters the list of logo types.
         *
         * @param array $defaults (required) The list of default logo types.
         *
         * @since 1.0.0
         */
        $types = apply_filters( 'componentz/theme/logo_types', $defaults );
        
        // Sanitize the array.
        $types = array_map( 'esc_attr', $types );

        return array_unique( $types );
    }
    
    /**
     * Right Menu Defaults
     *
     * The right side menu defaults.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function right_menu_defaults() {
        $defaults = [
            [
                'media' => 'social'  
            ],
            [
                'media' => 'search'
            ],
            [
                'media' => 'account'
            ]
        ];
        
        /**
         * Filters the list of right menu defaults.
         *
         * @param array $defaults (required) The default list of menu items.
         *
         * @since 1.0.0
         */
        $items = apply_filters( 'componentz/theme/right_menu_defaults', $defaults );
        
        // Sanitize the array.
        $items = self::sanitize_multidimensional_array( $items );
        
        return $items;
    }
    
    /**
     * Right Menu Fields
     *
     * The right menu fields.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function right_menu_fields() {
        $defaults = [
            ''        => __( '-- Select --', 'componentz' ),
            'social'  => __( 'Social Media Links', 'componentz' ),
            'search'  => __( 'Search Field', 'componentz' ),
            'account' => __( 'My Account', 'componentz' )
        ];
        
        /**
         * Filters the list of right menu fields.
         *
         * @param array $defaults (required) The default list of menu fields.
         *
         * @since 1.0.0
         */
        $fields = apply_filters( 'componentz/theme/right_menu_fields', $defaults );
        
        // Sanitize array list.
        $fields = array_map( 'esc_attr', $fields );
        
        return array_unique( $fields );
    }
    
    /**
     * Social Icons
     *
     * The list of theme social icons.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function social_icons() {
        $defaults = [
            ''         => __( '-- Select --', 'componentz' ),
            'facebook' => __( 'Facebook', 'componentz' ),
            'twitter'  => __( 'Twitter', 'componentz' ),
            'youtube'  => __( 'YouTube', 'componentz' ),
            'rss'      => __( 'RSS', 'componentz' )
        ];
        
        /**
         * Filters the list of social icons.
         *
         * @param array $defaults (required) The list of default social icons.
         *
         * @since 1.0.0
         */
        $icons = apply_filters( 'componentz/theme/social_icons', $defaults );
        
        // Sanitize array list.
        $icons = array_map( 'esc_attr', $icons );
        
        // Ascending order.
        asort( $icons );
        
        return array_unique( $icons );
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
