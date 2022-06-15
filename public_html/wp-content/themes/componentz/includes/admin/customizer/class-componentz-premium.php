<?php
/**
 * Premium
 *
 * Register and initialize the componentz Premium section.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.2.0
 */

namespace Componentz\Admin;

// Do not allow direct access.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Componentz_Premium extends \Componentz\Theme {
    
    /**
     * Get Instance
     *
	 * Returns the instance.
	 *
	 * @since  1.2.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}
    
    /**
	 * Constructor method.
	 *
	 * @since  1.2.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}
    
    /**
     * Setup Actions
     *
	 * Sets up initial actions.
	 *
	 * @since  1.2.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', [ $this, 'sections' ] );
        
        // Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_control_scripts' ], 0 );

	}
    
    /**
     * Sections
     *
	 * Sets up the customizer sections.
	 *
	 * @since  1.2.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {
        
        // Load premium section.
        get_template_part( 'includes/admin/customizer/premium/class-componentz-section-premium' );

		// Register custom section types.
		$manager->register_section_type( __NAMESPACE__ . '\Customize_Section_Premium' );

		// Register sections.
		$manager->add_section(
			new Customize_Section_Premium(
				$manager,
				'componentz-premium',
				[
					'title'        => esc_html__( 'Get More Options', 'componentz' ),
					'premium_text' => esc_html__( 'Go Premium', 'componentz' ),
					'premium_url'  => 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-top&amp;utm_medium=go-premium-link&amp;utm_campaign=customizer',
                    'priority'     => 1
				]
			)
		);
	}
    
    /**
     * Enqueue Control Scripts
     *
	 * Loads the componentz theme customizer control scripts.
	 *
	 * @since  1.2.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_script( 
            'componentz-premium-customize-controls',
            $this->uriPath( "includes/admin/customizer/premium/customize-controls.js" ),
            [ 'customize-controls' ],
            $this->version(),
            true
        );
	}
    
}

Componentz_Premium::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
