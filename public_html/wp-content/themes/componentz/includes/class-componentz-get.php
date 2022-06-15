<?php
/**
 * Settings Class
 *
 * Componentz class to return various settings or template parts.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

namespace Componentz;

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Get {

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
     * Meta
     *
     * Retrieve a post meta value.
     *
     * @param string $key (required) The post meta key.
     * @param string|array|bool $default (optional) The default meta value if none retrieved.
     * @param int $post_id (optional) The post ID.
     *
     * @since 1.0.1
     * @access public
     * @return bool|string|array
     */
    public function meta( $key, $default = false, $post_id = false ) {
        global $post;
    
        // Sanitize key.
        $key = esc_attr( $key );

        /**
         * If we are on default homepage.
         * Return early and apply settings set in customizer.
         */
        if( is_home() && is_front_page() ) {
            return; 
        }
        
        /**
         * If we are on WooCommerce shop loop page.
         * Return early and apply settings set in cusotmizer.
         */
        if( Componentz()->helper->is_shop() ) {
            return;
        }

        /**
         * If we are on static homepage.
         */
        else if( is_front_page() ) {
            $post_id = esc_attr( get_option( 'page_on_front' ) );
        }

        /**
         * If we are on blog page.
         */
        else if( is_home() && ! is_front_page() ) {
            $post_id = esc_attr( get_option( 'page_for_posts' ) );
        }

        /**
         * If $post_id is not set, let's take it from global $post object.
         */
        else if( ! $post_id && is_object( $post ) ) {
            $post_id = esc_attr( $post->ID );
        }

        /**
         * If post meta key not found or empty, let's return default value.
         */
        if( ! get_post_meta( $post_id, $key, true ) ) {
            return esc_attr( $default );
        }
        
        return get_post_meta( $post_id, $key, true );
    }
    
    /**
     * Wrapper Class
     *
     * Componentz main wrapper class.
     *
     * @since 1.0.1
     * @access public
     * @return string
     */
    public function wrapper_class() {
        if( has_action( 'componentz/theme/wrapper_class' ) ) {
            /**
             * Hook: componentz/theme/wrapper_class
             *
             * @hooked none
             *
             * @since 1.0.1
             */
            do_action( 'componentz/theme/wrapper_class' );
        } else {
            echo esc_attr( 'componentz-layout-widewidth' );
        }
    }

	/**
	 * Header Wrapper Class
	 *
	 * Output header wrapper classes.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function header_class() {
        $settings = esc_attr( get_theme_mod( 'componentz_header', 'v1' ) );
        $sticky = esc_attr( get_theme_mod( 'componentz_header_sticky', true ) );
        
        // Default header class.
        $class = [ 'header-'. $settings ];
        
        // If sticky header enabled let's apply proper class name.
        if( $sticky ) {
            $class = array_merge( $class, [ 'sticky-header' ] );
        }
        
        /**
         * Filters the list of header classes.
         *
         * @param string $class (required) Default header class.
         *
         * @since 1.0.0
         */
		$classes = apply_filters( 'componentz/theme/header_class', $class );
        
        // Sanitize array list.
        $classes = array_map( 'esc_attr', $classes );
        
        // Only unique class names.
        $classes = array_unique( $classes );
        
        echo implode( ' ', $classes ); // phpcs:ignore
	}

    /**
     * Sticky Header Background
     *
     * Output sticky header background.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function sticky_header_background() {
        $sticky = esc_attr( get_theme_mod( 'componentz_header_sticky', true ) );

        if ( $sticky ) : ?>
            <div class="container-sticky-header-background"></div>
        <?php 
        endif;
    }
    
    /**
     * Logo Wrapper Class
     *
     * Generate logo wrapper class name by logo type.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function logo_wrapper_class() {
        $type = esc_attr( get_theme_mod( 'componentz_logo_type', 'title' ) );
        switch( $type ) {
            case 'title' :
                $class = 'cz-logo-title';
            break;
            case 'logo' :
                $class = 'cz-logo-image';
            break;
            case 'logo-title' :
                $class = 'cz-logo-image-title';
            break;
        }
        echo esc_attr( $class );
    }

	/**
	 * Logo
	 *
	 * Display Componentz logo.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function logo() {
        
		$type       = esc_attr( get_theme_mod( 'componentz_logo_type', 'title' ) );
		$logo       = esc_url( get_theme_mod( 'componentz_logo' ) );
        $logo_hover = esc_url( get_theme_mod( 'componentz_logo_hover', false ) );
        
		if ( 'logo' == $type && $logo ) { ?>
            
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
               title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                
                <img src="<?php echo esc_url( $logo ); //phpcs:ignore ?>" 
                     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
                     class="logo-img">
                
                <?php if( $logo_hover ) { ?>
                
                <img src="<?php echo esc_url( $logo_hover ); //phpcs:ignore ?>" 
                     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
                     class="logo-img-sticky">
                
                <?php } else { ?>
                
                <img src="<?php echo esc_url( $logo ); //phpcs:ignore ?>" 
                     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
                     class="logo-img-sticky">
                
                <?php } ?>
                
            </a>
            
        <?php } else if ( 'title' == $type ) { ?>
            <h2>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                    <?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?>
                </a>
            </h2>
        <?php
		}
	}

	/**
	 * Menu
	 *
	 * Displays a navigation menu.
	 *
	 * @param string $location (optional) The actual menu location.
     * @param string $menu_type (optional) Type of the menu.
	 * @param string $class (optional) The menu wrapper class name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function menu( $location = null, $menu_type = null, $menu_class = 'cz-nav cz-navbar-nav' ) {
		$args            = [];
		$container_id    = str_replace( '_', '-', $location ) . '-collapse';
		$container_class = 'cz-collapse cz-navbar-collapse';
        
        if( ! empty( $menu_type ) ) {
            $args['menu_type'] = esc_attr( $menu_type );
        }
        
        /**
         * The Menu Arguments
         */
		$args = [
			'theme_location'  => esc_attr( $location ),
			'depth'           => 5,
			'container'       => 'div',
			'container_class' => esc_attr( $container_class ),
			'container_id'    => esc_attr( $container_id ),
			'menu_class'      => esc_attr( $menu_class ),
			'walker'          => new NavWalker(),
            'fallback_cb'     => NavWalker::fallback(
                [
                    'theme_location'  => esc_attr( $location ),
                    'depth'           => 5,
                    'container'       => 'div',
                    'menu_id'         => esc_attr( $container_id ),
                    'menu_class'      => esc_attr( $container_class ),
                ]
            )
		];

		wp_nav_menu( $args );
	}

    /**
	 * Raw Menu
	 *
	 * Displays the raw navigation menu without div wrapper.
	 *
	 * @param string $location (optional) The actual menu location.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
    public function rawMenu( $location = null ) {
        
        /**
         * The Menu Arguments
         */
        $args = [
            'menu_type'      => 'mobile',
            'theme_location' => esc_attr( $location ),
            'depth'          => 5,
            'container'      => false,
            'walker'         => new NavWalker(),
            'fallback_cb'    => NavWalker::fallback(
                [
                    'theme_location' => esc_attr( $location ),
                    'depth'          => 5,
                    'container'      => false
                ]
            )
        ];

        wp_nav_menu( $args );
    }

	/**
	 * Social Icons
	 *
	 * Display social icons.
	 *
	 * @param string $id (optional) The social icons wrapper id name.
	 * @param string $class (optional) The social icons wrapper class name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 */
	public function social_icons( $id = 'cz-social-icons-menu', $class = 'cz-dropdown-menu cz-social-icons' ) {
		$defaults = [
			[
				'media' => esc_attr__( 'RSS', 'componentz' ),
				'url'   => esc_url( get_bloginfo_rss( 'rss2_url' ) )
			]
		];

		$settings = get_theme_mod( 'componentz_social_icons', $defaults ); ?>

		<ul id="<?php echo esc_attr( $id ); ?>"
            class="<?php echo esc_attr( $class ); ?>" 
            aria-labelledby="cz-social-icons-nav""><?php
            foreach ( $settings as $setting ) {
            $target = isset( $setting['target'] ) ? '_blank' : '_self'; ?>
			<li class="cz-<?php echo esc_attr( strtolower( $setting['media'] ) ); ?>">
			     <a class="cz-nav-link cz-social-icon sub-menu-item" 
                    href="<?php echo esc_url( $setting['url'] ); ?>" rel="noreferrer" target="<?php echo esc_attr( $target ); //phpcs:ignore ?>">
                    <?php echo Componentz()->svg->icon( 'cz-icon-' . esc_attr( strtolower( $setting['media'] ) ) )  . ' ' . esc_html( ucfirst( $setting['media'] ) ); //phpcs:ignore ?>
                </a>
			</li>
		  <?php } ?>
		</ul>
        <?php
	}
    
    /**
     * Single Post Categories
     *
     * Display single post categories in jumbotron.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function single_post_categories() {
        global $post;
        if( is_single() ) {
            $dot = '<span class="dot cz-mx-2"></span>';
            $categories = Componentz()->helper->post_categories( $post->ID );
            if( $categories ) { ?>
                <ul class="cz-d-inline-block post-meta"><?php
                    foreach( $categories as $category ) {
                        if( $category === end( $categories ) ) {
                            $dot = '';
                        } ?>
                        <li class="cat-link">
                            <a href="<?php echo esc_url( $category['url'] ); ?>" 
                               title="<?php echo esc_attr( $category['name'] ); ?>">
                                <?php echo esc_html( $category['name'] ); ?>
                            </a><?php echo wp_kses( $dot, [ 'span' => [ 'class' => [] ] ] ); // phpcs:ignore ?>
                        </li>
                    <?php } ?>
                </ul>
                <?php
            }
        }
    }
    
    /**
     * Single Product Categories
     *
     * Display single product categories in jumbotron.
     *
     * @since 1.0.1
     * @access public
     * @return mixed
     */
    public function single_product_categories() {
        global $post;
        $dot = '<span class="dot cz-mx-2"></span>';
        $terms = get_the_terms( $post->ID, 'product_cat' );
        if( ! empty( $terms ) ) { ?>
            <ul class="cz-d-inline-block post-meta"><?php
            foreach( $terms as $term ) {
                if( $term === end( $terms ) ) {
                    $dot = '';
                }
                $cat_id  = esc_attr( $term->term_id );
                $cat_url = get_category_link( $cat_id ); ?>
                <li class="cat-link">
                    <a href="<?php echo esc_url( $cat_url ); ?>" 
                       title="<?php echo esc_attr( $term->name ); ?>">
                        <?php echo esc_html( $term->name ); ?>
                    </a><?php echo wp_kses( $dot, [ 'span' => [ 'class' => [] ] ] ); // phpcs:ignore ?>
                </li>
            <?php } ?>
            </ul>
            <?php
        }
    }
    
    /**
     * Layout
     *
     * Output componentz layout style.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function content_layout() {
        $layout  = esc_attr( get_theme_mod( 'componentz_content_layout', 'eight-three' ) );
        $_layout = esc_attr( $this->meta( '_componentz_content_layout' ) );
        
        // Post meta has a priority.
        if( ! empty( $_layout ) ) {
            $layout = $_layout;
        }
        
        return $layout;
    }

	/**
	 * Primary Class
	 *
	 * Output primary content wrapper class.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function primary_class() {
		$class = esc_attr( 'primary' );

		if ( ! is_active_sidebar( 'componentz-sidebar' ) || 
             ! is_active_sidebar( 'componentz-woocommerce-sidebar' ) && 
             Componentz()->helper->is_woocommerce() || 
             'twelve' == $this->content_layout() ||
             is_search() && ! Componentz()->helper->is_woocommerce() ||
             is_404() || 
            ( is_archive() && ! Componentz()->helper->is_woocommerce() )
           ) 
        {
			$class = 'cz-col-12';
		}

        // bbPress support.
        if( function_exists( 'is_bbpress' ) ) {
            if( is_bbpress() && is_active_sidebar( 'componentz-sidebar' ) ) {
                $class = 'primary';
            }
        }

		echo esc_attr( $class );
	}

	/**
	 * Sidebar Class
	 *
	 * Output sidebar class.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function sidebar_class() {
		if ( is_active_sidebar( 'componentz-sidebar' ) || 
             is_active_sidebar( 'componentz-woocommerce-sidebar' ) && 
             Componentz()->helper->is_woocommerce() 
           ) 
        {
			echo esc_attr( 'secondary' );
		}
	}

	/**
	 * Footer Widget Class
	 *
	 * Output Bootstrap class depending on how many widgets are active.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function footer_widgets() {
		$settings = esc_attr( get_theme_mod( 'componentz_footer_widgets_layout', 'six-six' ) );
		if ( 'twelve' == $settings ) {
			if ( is_active_sidebar( 'componentz-footer-1' ) ) { ?>
				<div class="cz-col-12">
				    <?php dynamic_sidebar( 'componentz-footer-1' ); ?>
				</div><?php
			}
		} else if ( 'six-six' == $settings ) {
			if ( is_active_sidebar( 'componentz-footer-1' ) ) { ?>
				<div class="cz-col-md-6">
				    <?php dynamic_sidebar( 'componentz-footer-1' ); ?>
				</div><?php
			}
			if ( is_active_sidebar( 'componentz-footer-2' ) ) { ?>
				<div class="cz-col-md-6">
				    <?php dynamic_sidebar( 'componentz-footer-2' ); ?>
				</div><?php
			}
		} else if ( 'four-four-four' == $settings ) {
			if ( is_active_sidebar( 'componentz-footer-1' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-4">
				   <?php dynamic_sidebar( 'componentz-footer-1' ); ?>
				</div><?php
			}
			if ( is_active_sidebar( 'componentz-footer-2' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-4">
				    <?php dynamic_sidebar( 'componentz-footer-2' ); ?>
				</div><?php
			}
			if ( is_active_sidebar( 'componentz-footer-3' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-4">
				    <?php dynamic_sidebar( 'componentz-footer-3' ); ?>
				</div><?php
			}
		} else if ( 'three-three-three-three' == $settings ) {
			if ( is_active_sidebar( 'componentz-footer-1' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-3">
				    <?php dynamic_sidebar( 'componentz-footer-1' ); ?>
				</div><?php
			}
			if ( is_active_sidebar( 'componentz-footer-2' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-3">
				    <?php dynamic_sidebar( 'componentz-footer-2' ); ?>
				</div><?php
			}
			if ( is_active_sidebar( 'componentz-footer-3' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-3">
				    <?php dynamic_sidebar( 'componentz-footer-3' ); ?>
				</div><?php
			}
			if ( is_active_sidebar( 'componentz-footer-4' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-3">
				    <?php dynamic_sidebar( 'componentz-footer-4' ); ?>
				</div><?php
			}
		} else if ( 'six-three-three' == $settings ) {
			if ( is_active_sidebar( 'componentz-footer-1' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-6">
				    <?php dynamic_sidebar( 'componentz-footer-1' ); ?>
				</div>
            <?php
			}
			if ( is_active_sidebar( 'componentz-footer-2' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-3">
				    <?php dynamic_sidebar( 'componentz-footer-2' ); ?>
				</div>
            <?php
			}
			if ( is_active_sidebar( 'componentz-footer-3' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-3">
				    <?php dynamic_sidebar( 'componentz-footer-3' ); ?>
				</div>
            <?php
			}
		} else if ( 'four-eight' == $settings ) {
			if ( is_active_sidebar( 'componentz-footer-1' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-4">
				    <?php dynamic_sidebar( 'componentz-footer-1' ); ?>
				</div>
            <?php
			}
			if ( is_active_sidebar( 'componentz-footer-2' ) ) { ?>
				<div class="cz-col-md-6 cz-col-lg-8">
				    <?php dynamic_sidebar( 'componentz-footer-2' ); ?>
				</div>
            <?php
			}
		}
	}

    /**
     * Copyright Class
     *
     * Output custom copyright class depend if footer widgets are active or not.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function copyright_class() {
        $class = 'cz-col-md-12 cz-text-center';
        if( Componentz()->helper->is_footer_widgets_active() ) {
            $class = 'cz-col-md-3 cz-order-2 cz-order-md-1 cz-text-center cz-text-md-left';
        }
        echo esc_attr( $class );
    }

    /**
     * Copyright
     *
     * Componentz theme copyright text.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function copyright() { ?>
        <?php if( apply_filters( 'componentz/theme/copyright/display_website_name', true ) ) : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site-title">
            <?php if( has_action( 'componentz/theme/copyright/custom_logo' ) ) : ?>
                <?php
                /**
                 * Hook: componentz/theme/copyright/custom_logo
                 *
                 * @hooked none
                 *
                 * @since 1.0.1
                 */
                do_action( 'componentz/theme/copyright/custom_logo' ); ?>
            <?php else : ?>
                <span><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></span>
            <?php endif; ?>
        </a>
        <?php endif; ?>
        <div class="componentz-copyright-theme">
            <?php if( apply_filters( 'componentz/theme/copyright/enable_custom_copyright', false ) ) : ?>
                <?php apply_filters( 'componentz/theme/copyright/custom_copyright', false ); ?>
            <?php else : ?>
            <a href="<?php esc_attr_e( 'https://wordpress.org', 'componentz' ); ?>" title="<?php esc_attr_e( 'WordPress', 'componentz' ); ?>">
		        <?php esc_html_e( 'WordPress', 'componentz' ); ?>
            </a>
	        <?php esc_html_e( 'theme by', 'componentz' ); ?>
            <a href="<?php echo esc_url( 'https://componentz.co/theme' ); ?>" title="componentz">
                <?php echo Componentz()->svg->icon( 'cz-icon-componentz-logo' ); // phpcs:ignore ?>
                <?php esc_html_e( 'componentz', 'componentz' ); ?>
            </a>
            <?php endif; ?>
        </div>
    <?php
    }

    /**
     * Unique ID
     *
     * Return a unique ID with a user-defined prefix
     *
     * @since 1.2.2
     * @access public
     * @return string
     */
    public function unique_id( $prefix = '' ) {
        static $id_counter = 0;
        if ( function_exists( 'wp_unique_id' ) ) {
            return wp_unique_id( $prefix );
        }
        return $prefix . (string) ++$id_counter;
    }

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */