<?php
/**
 * Helper Class
 *
 * Componentz helper class.
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

class Helper {
    
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
     * Escape SVG
     *
     * Escape the SVG html with wp_kses function.
     *
     * @param mixed $svg (required) The SVG code which we want to escape.
     *
     * @since 1.0.8
     * @access public
     * @return mixed
     */
    public function escape_svg( $svg ) {
        $allowed_html = [
            'svg' => [
                'class' => [],
                'aria-hidden' => [],
                'role' => []
            ],
            'use' => [
                'xlink:href' => []
            ]
        ];
        
        echo wp_kses( $svg, $allowed_html ); //phpcs:ignore
    }
    
    /**
     * Escape Post Meta
     *
     * Escape the post meta data.
     *
     * @param mixded $meta (required) The post meta data for escape.
     *
     * @since 1.0.8
     * @access public
     * @return mixed
     */
    public function escape_post_meta( $meta ) {
        $allowed_html = [
            'span' => [
                'class' => []
            ],
            'a' => [
                'href' => [],
                'rel' => [],
                'id' => [],
                'class' => []
            ],
            'time' => [
                'class' => [],
                'datetime' => []
            ]
        ];
        
        echo wp_kses( $meta, $allowed_html );
    }
    
    /**
     * Escape Categories List
     *
     * Escapes the categories list.
     *
     * @param string $categories (required) The category list to escape.
     *
     * @since 1.1.6
     * @access public
     * @return string
     */
    public function escape_categories_list( $categories ) {
        if( $categories ) {
            return wp_kses( $categories, [
                'a' => [
                    'href' => [],
                    'rel' => []
                ],
                'span' => [
                    'class' => []
                ]
            ] );
        }
        return false;
    }

    /**
     * Escape Pagination
     *
     * Escape the blog posts pagination.
     *
     * @param mixded $nav (required) The posts navigation to escape.
     *
     * @since 1.0.8
     * @access public
     * @return mixed
     */
    public function escape_pagination( $nav ) {
        $allowed_html = [
            'nav' => [
                'id' => [],
                'class' => [],
                'role' => [],
                'aria-label' => []
            ],
            'h2' => [
                'id' => [],
                'class' => []
            ],
            'div' => [
                'id' => [],
                'class' => []
            ],
            'a' => [
                'href' => [],
                'class' => []
            ],
            'span' => [
                'aria-current' => [],
                'class' => []
            ],
            'svg' => [
                'class' => [],
                'aria-hidden' => [],
                'role' => []
            ],
            'use' => [
                'xlink:href' => []
            ]
        ];
        
        echo wp_kses( $nav, $allowed_html );
    }
    
    /**
     * Is bbPress
     *
     * Determine if we are on bbPress pages.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function is_bbpress() {
        if( function_exists( 'is_bbpress' ) ) {
            return is_bbpress();
        }
        return false;
    }
    
    /**
     * bbPress is Forum Archive
     *
     * Determine if we are on bbPress archive pages.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function bbp_is_forum_archive() {
        if( $this->is_bbpress() ) {
            return bbp_is_forum_archive();
        }
        return false;
    }
    
    /**
     * bbPress is Single Forum
     *
     * Determine if we are on bbPress single forum page.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function bbp_is_single_forum() {
        if( $this->is_bbpress() ) {
            return bbp_is_single_forum();
        }
        return false;
    }
    
    /**
     * Is Shop
     *
     * Determine if we are on WooCommerce shop page.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function is_shop() {
        if( class_exists( 'Woocommerce' ) ) {
            return is_shop();
        }
        return false;
    }
    
    /**
     * Is WooCommerce
     *
     * Determine if we are on WooCommerce pages.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function is_woocommerce() {
        if( class_exists( 'Woocommerce' ) ) {
            return is_woocommerce();
        }
        return false;
    }
    
    /**
     * Header Right Side Active
     *
     * Check if requested media is active on header right menu side.
     *
     * @param string $media (optional) The media name.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function is_header_right_side_active( $media = false ) {
        $rmenus = get_theme_mod( 'componentz_menu_items_right', [
            [
                'media' => 'social'  
            ],
            [
                'media' => 'search'
            ],
            [
                'media' => 'account'
            ]
        ] );
        
        $output['status'] = false;
        
        if( $rmenus ): foreach( $rmenus as $rmenu ) {
            // If $media not set, check if any from media is active.
            if( ! $media ) {
                if( 'social' == $rmenu['media'] || 
                    'search' == $rmenu['media'] || 
                    'account' == $rmenu['media'] ) {
                    $output['status'] = true;
                }
            }
            // Else if $media is set lets check if asked $media is active.
            elseif( $media == $rmenu['media'] ) {
                $output['status'] = true;
            }
        }  endif;
        
        return $output['status'];
    }
    
    /**
     * Social Icons Active
     *
     * Check if social icons are active.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function is_social_icons_active() {
        $defaults = [
            [
                'media' => __( 'RSS', 'componentz' ),
                'url'   => esc_url( get_bloginfo_rss( 'rss2_url' ) )
            ]
        ];
        
        $settings = get_theme_mod( 'componentz_social_icons', $defaults );
        
        $output['status'] = false;
        foreach( $settings as $setting ) {
            if( ! empty( $setting['url'] ) ) {
                $output['status'] = true;
            }
        }
        
        return $output['status'];
    }
    
    /**
     * Post Categories
     *
     * Display post categories for given post ID.
     *
     * @param int $post_id (optional) The current post ID we want display categories.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function post_categories( $post_id = null ) {
        if( ! empty( $post_id ) ) {
            
            // Get current post categories.
            $post_categories = wp_get_post_categories( $post_id );
            $cats = [];
            
            foreach( $post_categories as $category ) {
                $cat = get_category( $category );
                $cats[] = [ 
                    'name' => esc_html( $cat->name ), 
                    'url' => esc_url( get_category_link( $cat->cat_ID ) ) 
                ];
            }
            
           return $cats;
        }
    }
    
    /**
     * Footer Widgets Active
     *
     * Check's if footer widgets are active or not.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function is_footer_widgets_active() {
        $fw1 = is_active_sidebar( 'componentz-footer-1' );
        $fw2 = is_active_sidebar( 'componentz-footer-2' );
        $fw3 = is_active_sidebar( 'componentz-footer-3' );
        $fw4 = is_active_sidebar( 'componentz-footer-4' );
        
        // If any widget active, return true.
        if( $fw1 || $fw2 || $fw3 || $fw4 ) {
            return true;
        }
        
        return false;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
