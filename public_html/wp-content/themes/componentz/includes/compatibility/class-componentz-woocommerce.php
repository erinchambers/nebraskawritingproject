<?php
/**
 * WooCommerce
 *
 * The componentz WooCommerce plugin compatibility.
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


class WooCommerce {
    
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

        // Unhook WooCommerce wrappers.
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

        // Hook componentz primary wrapper.
        add_action('woocommerce_before_main_content', [ $this, 'wrapper_start' ], 10 );
        add_action('woocommerce_after_main_content', [ $this, 'wrapper_end' ], 10 );

        // Hook componentz secondary wrapper.
        add_action( 'woocommerce_after_main_content', [ $this, 'secondary_wrapper' ], 10 );

        // Hook componentz primary sub-wrapper.
        add_action( 'woocommerce_before_main_content', [ $this, 'subwrapper_start' ], 11 );
        add_action( 'woocommerce_after_main_content', [ $this, 'subwrapper_end' ], 9 );

        // Unhook WooCommerce single page product title.
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

        // Unhook WooCommerce breadcrumb.
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

        // Remove WooCommerce sidebar.
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

    }

    /**
     * Primary Wrapper Start
     *
     * Add componentz primary wrapper on WooCommerce pages.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function wrapper_start() { ?>
        <section id="primary" class="<?php Componentz()->get->primary_class(); ?>"><?php
    }

    /**
     * Primary Wrapper End
     *
     * Close componentz primary wrapper on WooCommerce pages.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function wrapper_end() { ?>
        </section><!-- #primary --><?php
    }

    /**
     * Secondary Wrapper
     *
     * Display secondary wrapper on WooCommerce pages.
     *
     * @since 1.0.1
     * @access public
     * @return mixed
     */
    public function secondary_wrapper() {
        get_sidebar( 'woocommerce' );
    }

    /**
     * Primary Sub-Wrapper Start
     *
     * Add componentz primary sub-wrapper on WooCommerce pages.
     *
     * @since 1.0.1
     * @access public
     * @return mixed
     */
    public function subwrapper_start() { ?>
        <div class="primary-sub-wrapper">
    <?php
    }

    /**
     * Primary Sub-Wrapper End
     * 
     * Close componentz primary sub-wrapper on WooCommerce pages.
     *
     * @since 1.0.1
     * @access public
     * @return mixed
     */
    public function subwrapper_end() { ?>
        </div><!-- .primary-sub-wrapper -->
    <?php 
    }

}

WooCommerce::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
