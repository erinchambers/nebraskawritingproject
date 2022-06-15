<?php
/**
 * Section Premium
 *
 * Adds the Premium button section in the customize top area.
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

class Customize_Section_Premium extends \WP_Customize_Section {
    
    /**
     * Type
     *
	 * The type of customize section being rendered.
	 *
	 * @since  1.2.0
	 * @access public
	 * @var    string
	 */
	public $type = 'componentz-premium';

	/**
     * Premium Text
     *
	 * Custom button text to output.
	 *
	 * @since  1.2.0
	 * @access public
	 * @var    string
	 */
	public $premium_text = '';

	/**
     * Premium URL
     *
	 * Custom premium button URL.
	 *
	 * @since  1.2.0
	 * @access public
	 * @var    string
	 */
	public $premium_url = '';

	/**
     * Json
     *
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.2.0
	 * @access public
	 * @return void
	 */
	public function json() {
		$json = parent::json();

		$json['premium_text'] = $this->premium_text;
		$json['premium_url']  = esc_url( $this->premium_url );

		return $json;
	}

	/**
     * Render Template
     *
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.2.0
	 * @access public
	 * @return void
	 */
	protected function render_template() { ?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

			<h3 class="accordion-section-title">
				{{ data.title }}

				<# if ( data.premium_text && data.premium_url ) { #>
					<a href="{{ data.premium_url }}" class="button button-secondary alignright" target="_blank">{{ data.premium_text }}</a>
				<# } #>
			</h3>
		</li>
	<?php }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
