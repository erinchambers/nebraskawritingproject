<?php
/**
 * bbPress
 *
 * The componentz bbPress plugin compatibility.
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


class bbPress {
 
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
        
        add_filter( 'protected_title_format', [ $this, 'remove_protected_title' ] );
        add_filter( 'private_title_format', [ $this, 'remove_private_title' ] );
        
    }
    
    /**
     * Remove Protected Title
     *
     * Custom Remove 'Protected:' title prefix.
     * 
     * @param string $title (required) The title.
     *
     * @since 1.1.2
     * @access public
     * @return string
     */
    public function remove_protected_title( $title ) {
        return '%s';
    }
    
    /**
     * Remove Private Title
     *
     * Custom Remove 'Private:' title prefix.
     *
     * @param string $title (required) The title.
     *
     * @since 1.1.2
     * @access public
     * @return string
     */
    function remove_private_title( $title ) { 
        return '%s';
    }
    
    
}

bbPress::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
