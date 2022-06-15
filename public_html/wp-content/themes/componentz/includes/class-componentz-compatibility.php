<?php
/**
 * Compatibility
 *
 * The componentz third party plugins compatibility class.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.1.2
 */

namespace Componentz;

// Do not allow direct access.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Compatibility {
    
    /**
	 * Instance
	 *
	 * Single instance of this object.
	 *
	 * @since 1.1.2
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * Get Instance
	 *
	 * Access the single instance of this class.
	 *
	 * @since 1.1.2
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
        
        $this->third_party_plugins();
        
    }
    
    /**
     * Third Party Plugins
     *
     * Check what third party plugins are installed and load proper comaptibility class file.
     *
     * @since 1.1.2
     * @access private
     * return void
     */
    private function third_party_plugins() {
        
        // bbPress
        if( class_exists( 'bbPress' ) ) {
            get_template_part( 'includes/compatibility/class-componentz-bbpress' );
        }
        
        // WooCommerce
        if( class_exists( 'WooCommerce' ) ) {
            get_template_part( 'includes/compatibility/class-componentz-woocommerce' );
        }
        
    }
    
}

Compatibility::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
