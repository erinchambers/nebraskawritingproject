<?php
/**
 * Customizer Class
 *
 * Componentz customizer class.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

namespace Componentz\Admin;

use Componentz\Theme;
use Kirki;

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Customizer extends Theme {

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
	public function __construct() {
        global $wp_customize;

        // If Kirki class not found return early.
        if( ! class_exists( 'Kirki' ) ) {
            return;
        }

        // Enqueue panel script.
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'controls_scripts' ] );

		// Enqueue print scripts and styles.
		add_action( 'customize_controls_print_scripts', [ $this, 'controls_print_scripts' ] );

		// Enqueue preview scripts and styles.
		add_action( 'customize_preview_init', [ $this, 'preview_scripts' ] );

		// Customize register.
		add_action( 'customize_register', [ $this, 'customize_register' ] );

		// Include Kirki framework.
		get_template_part( 'includes/admin/kirki/kirki' );

		// Disable telemetry module.
		add_filter( 'kirki_telemetry', '__return_false' );

        // Kirki config.
        add_filter( 'kirki_config', [ $this, 'kirki_config' ] );

        // Add loader styles.
        if( $wp_customize ) {
            add_action( 'wp_head', [ $this, 'add_loader_styles_to_header' ], 99 );
        }

		// Add theme config.
		Kirki::add_config( 'componentz_theme_option', [
			'option_type' => 'theme_mod',
			'capability'  => 'edit_theme_options'
		] );

		// Add panels, sections & fields.
		$this->addPanels();
		$this->addSections();
		$this->addFields();

	}

    /**
     * Control Scripts
     *
     * Load dynamic logic for the customizer controls area.
     *
     * @since 1.0.0
     * @access public
     * @return null
     */
    public function controls_scripts() {
        wp_enqueue_script(
            'componentz-customize-controls',
            $this->uriPath( "assets/js/customize-controls{$this->suffix()}.js" ),
            [ 'customize-controls' ],
            $this->version(),
            true
        );
    }

	/**
	 * Controls Print Scripts
	 *
	 * Enqueue customize controls print scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return null
	 */
	public function controls_print_scripts() {
		wp_enqueue_script(
            'componentz-customizer',
            $this->uriPath( "assets/js/customizer{$this->suffix()}.js" ),
            [],
            $this->version()
        );

		wp_enqueue_style(
            'componentz-lato',
            'https://fonts.googleapis.com/css?family=Lato:400,900'
        );

		wp_enqueue_style(
            'componentz-customizer',
            $this->uriPath( "assets/css/customizer-style{$this->suffix()}.css" ),
            [],
            $this->version()
        );
	}

	/**
	 * Preview Script
	 *
	 * Enqueue customize preview scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 * return null
	 */
	public function preview_scripts() {
		wp_enqueue_script(
            'componentz-customize-preview',
            $this->uriPath( "assets/js/customize-preview{$this->suffix()}.js" ),
            [ 'customize-preview', 'customize-selective-refresh' ],
            $this->version(),
            true
        );
	}

	/**
	 * Customize Register
	 *
	 * Access to $wp_customize object.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return null
	 */
	public function customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport           = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport    = 'postMessage';
        $wp_customize->get_setting( 'header_image' )->transport       = 'postMessage';
        $wp_customize->get_setting( 'header_image_data'  )->transport = 'postMessage';
        $wp_customize->remove_section( 'colors' );
        $wp_customize->selective_refresh->add_partial(
            'header_image',
            [
                'selector'        => '#componentz-header .simpleParallax .simpleParallax',
                'render_callback' => 'componentz_header_image',
            ]
        );
    }

    /**
     * Kirki Config
     *
     * The Kirki configuration settings.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public function kirki_config( $config ) {
        return wp_parse_args( [
            'disable_loader' => true
        ], $config );
    }

    /**
     * Loader Styles
     *
     * Add customize loader styles to header.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function add_loader_styles_to_header() { ?>
		<style>
            body.wp-customizer-unloading {
				opacity: 1;
				cursor: progress !important;
				-webkit-transition: none;
				transition: none;
			}
			body.wp-customizer-unloading * {
				pointer-events: none !important;
			}
            body:not(.wp-customize-unloading) #fader {
                opacity: 0;
            }
            body.wp-customizer-unloading #fader {
				display: block;
				opacity: 1;
			}
        </style>
        <?php
    }

	/**
	 * Panels
	 *
	 * Panels are wrappers for sections, a way to group multiple sections together.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return mixed
	 */
	private function addPanels() {

        if( has_action( 'componentz/theme/kirki_panels' ) ) {
            /**
             * Hook: componentz/theme/kirki_panels
             *
             * @hooked none
             *
             * @since 1.0.1
             */
            do_action( 'componentz/theme/kirki_panels' );
        }

        /**
         * Effects & Features [Panel]
         ********************************************/
        Kirki::add_panel( 'componentz_features_panel', [
            'title' => esc_html__( 'Effects & Features', 'componentz' ),
            'priority' => 11
        ] );
		/**
		 * Header [Panel]
		 ********************************************/
		Kirki::add_panel( 'componentz_header_panel', [
			'title' => esc_html__( 'Header', 'componentz' )
		] );
        /**
         * Typography [Panel]
         *************************************************/
        Kirki::add_panel( 'componentz_typography_panel', [
            'title'    => esc_html__( 'Typography', 'componentz' ),
            'priority' => 7
        ] );
        /**
         * Colors & Styling [Panel]
         *************************************************/
        Kirki::add_panel( 'componentz_colors_panel', [
            'title'    => esc_html__( 'Colors & Styling', 'componentz' ),
            'priority' => 8
        ] );
		/**
		 * Footer [Panel]
		 ********************************************/
		Kirki::add_panel( 'componentz_footer_panel', [
			'title' => esc_html__( 'Footer', 'componentz' )
		] );
	}

	/**
	 * Sections
	 *
	 * Sections are wrappers for controls, a way to group multiple controls together.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return mixed
	 */
	private function addSections() {

        if( has_action( 'componentz/theme/kirki_sections' ) ) {
            /**
             * Hook: componentz/theme/kirki_sections
             *
             * @hooked none
             *
             * @since 1.0.1
             */
            do_action( 'componentz/theme/kirki_sections' );
        }

		/**
		 * Main layout [Section]
		 *****************************************************/
		Kirki::add_section( 'componentz_theme_layout_section', [
			'title' => esc_html__( 'Main Layout', 'componentz' ),
			'priority' => 2
		] );
		/**
		 * Header [Section]
		 ********************************************************/
        Kirki::add_section( 'header_image', [
            'title' => esc_html__( 'Header', 'componentz' ),
            'priority' => 3
        ] );
        /**
         * Header Navigation [Section]
         *****************************************************/
        Kirki::add_section( 'componentz_menu_section', [
            'title' => esc_html__( 'Header Navigation', 'componentz' ),
            'priority' => 4
        ] );
        /**
         * Logo & site title [Section]
         *****************************************************/
        Kirki::add_section( 'componentz_logo_title_section', [
            'title' => esc_html__( 'Logo & Site Title', 'componentz' ),
            'priority' => 5
        ] );
		/**
		 * Typography [Sections]
		 *****************************************************/
		Kirki::add_section( 'componentz_typography_body_section', [
			'title' => esc_html__( 'Body', 'componentz' ),
            'panel' => 'componentz_typography_panel'
		] );
        Kirki::add_section( 'componentz_typography_menu_section', [
            'title' => esc_html__( 'Header Navigation', 'componentz' ),
            'panel' => 'componentz_typography_panel'
        ] );
        Kirki::add_section( 'componentz_typography_site_title_section', [
            'title' => esc_html__( 'Site Title', 'componentz' ),
            'panel' => 'componentz_typography_panel',
        ] );
        Kirki::add_section( 'componentz_typography_site_title_section', [
            'title' => esc_html__( 'Site Title', 'componentz' ),
            'panel' => 'componentz_typography_panel',
        ] );
        Kirki::add_section( 'componentz_typography_header_section', [
            'title' => esc_attr__( 'Header', 'componentz' ),
            'panel' => 'componentz_typography_panel',
        ] );
		/**
		 * Colors & Styling [Section]
		 *****************************************************/
		Kirki::add_section( 'componentz_main_color_section', [
			'title' => esc_html__( 'Main Colors', 'componentz' ),
            'panel' => 'componentz_colors_panel',
            'priority' => 1
		] );
        Kirki::add_section( 'componentz_colors_buttons_section', [
            'title' => esc_html__( 'Buttons', 'componentz' ),
            'panel' => 'componentz_colors_panel',
            'priority' => 9
        ] );
		/**
		 * Front Page & Blog [Section]
		 *****************************************************/
		Kirki::add_section( 'componentz_blog_section', [
			'title' => esc_html__( 'Front Page & Blog', 'componentz' ),
            'priority' => 9
		] );
		/**
		 * Social media links [Section]
		 *****************************************************/
		Kirki::add_section( 'componentz_social_section', [
			'title' => esc_html__( 'Social Media Links', 'componentz' ),
            'priority' => 10
		] );
        /**
         * Effects & Features [Section]
         *****************************************************/
        Kirki::add_section( 'componentz_page_preloader', [
            'title' => esc_html__( 'Page Preloader Effect', 'componentz' ),
            'panel' => 'componentz_features_panel',
            'priority' => 1
        ] );
        /**
         * Footer [Section]
         *****************************************************/
        Kirki::add_section( 'componentz_footer_section', [
            'title' => esc_html__( 'Footer', 'componentz' ),
            'priority' => 12
        ] );
    }

	/**
	 * Fields
	 *
	 * Fields are various
	 *
	 * @since 1.0.0
	 * @access private
	 * @return mixed
	 */
	private function addFields() {

        if( has_action( 'componentz/theme/kirki_fields' ) ) {
            /**
             * Hook: componentz/theme/kirki_fields
             *
             * @hooked none
             *
             * @since 1.0.1
             */
            do_action( 'componentz/theme/kirki_fields' );
        }

		/**
		 * Main layout [Fields]
		 ********************************************/

		Kirki::add_field( 'componentz_theme_option', [
			'label'     => esc_html__( 'Content Layout', 'componentz' ),
			'tooltip'   => __( 'Select the content layout type', 'componentz' ),
			'settings'  => 'componentz_content_layout',
			'section'   => 'componentz_theme_layout_section',
			'type'      => 'radio-image',
			'transport' => 'postMessage',
			'choices'   => [
				'twelve'      => esc_url( get_template_directory_uri() . '/assets/img/main-layout-12.svg' ),
				'eight-three' => esc_url( get_template_directory_uri() . '/assets/img/main-layout-8-3.svg' )
			],
			'default'   => 'eight-three',
            'priority' => 2
		] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_layout_upsell',
                'section'     => 'componentz_theme_layout_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-layout&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

		/**
		 * Header [Fields]
		 ********************************************/

		Kirki::add_field( 'componentz_theme_option', [
			'label'     => esc_html__( 'Header Background Style', 'componentz' ),
			'tooltip'   => __( 'Select the background style of the header', 'componentz' ),
			'settings'  => 'componentz_header_background',
			'section'   => 'header_image',
			'type'      => 'select',
			'transport' => 'postMessage',
			'choices'   => [
				'color'          => __( 'Color', 'componentz' ),
				'image'          => __( 'Header Image', 'componentz' ),
                'image-overlay'  => __( 'Header Image + Color Overlay', 'componentz' )
			],
			'default'   => 'image',
            'priority'  => 2
		] );
		Kirki::add_field( 'componentz_theme_option', [
			'label'           => esc_html__( 'Header Color #1 - Left Side', 'componentz' ),
			'tooltip'         => __( 'Set the header color on the left side', 'componentz' ),
			'settings'        => 'componentz_header_color_left',
			'section'         => 'header_image',
			'type'            => 'color',
			'transport'       => 'postMessage',
            'choices'         => [
                'alpha'       => true
            ],
			'active_callback' => [
                [
                    [
                        'setting'  => 'componentz_header_background',
                        'operator' => '==',
                        'value'    => 'color'
                    ],
                    [
                        'setting'  => 'componentz_header_background',
                        'operator' => '==',
                        'value'    => 'image-overlay'
                    ]
                ]
			],
			'default'         => '#0d55ff',
            'priority'        => 2
		] );
		Kirki::add_field( 'componentz_theme_option', [
			'label'           => esc_html__( 'Header Color #2 - Right Side', 'componentz' ),
			'tooltip'         => __( 'Set the header color on the right side', 'componentz' ),
			'settings'        => 'componentz_header_color_right',
			'section'         => 'header_image',
			'type'            => 'color',
			'transport'       => 'postMessage',
            'choices'         => [
                'alpha'       => true
            ],
			'active_callback' => [
                [
                    [
                        'setting'  => 'componentz_header_background',
                        'operator' => '==',
                        'value'    => 'color'
                    ],
                    [
                        'setting'  => 'componentz_header_background',
                        'operator' => '==',
                        'value'    => 'image-overlay'
                    ]
                ]
			],
			'default'         => '#0f99cb',
            'priority'        => 3
		] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'    => esc_html__( 'Header Image Position', 'componentz' ),
            'tooltip'  => __( 'Select the position for the header background image', 'componentz' ),
            'settings' => 'componentz_header_background_position',
            'section'  => 'header_image',
            'type'     => 'select',
            'transport'=> 'postMessage',
            'choices'  => [
                'top'    => __( 'Top', 'componentz' ),
                'center' => __( 'Center', 'componentz' ),
                'bottom' => __( 'Bottom', 'componentz' )
            ],
            'active_callback' => [
                [
                    [
                        'setting'  => 'componentz_header_background',
                        'operator' => '==',
                        'value'    => 'image'
                    ],
                    [
                        'setting'  => 'componentz_header_background',
                        'operator' => '==',
                        'value'    => 'image-overlay'
                    ]
                ]
            ],
            'default'  => 'center'
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_header_upsell',
                'section'     => 'header_image',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-header&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

        /**
         * Header Navigation [Fields]
         ********************************************/

        Kirki::add_field( 'componentz_theme_option', [
            'label'     => esc_html__( 'Enable Sticky Header Navigation', 'componentz' ),
            'tooltip'   => __( 'Check the box to enable the sticky header navigation', 'componentz' ),
            'settings'  => 'componentz_header_sticky',
            'section'   => 'componentz_menu_section',
            'type'      => 'checkbox',
            'default'   => true,
            'priority' => 1
        ] );

        Kirki::add_field( 'theme_config_id', [
            'label'        => esc_html__( 'Left Side', 'componentz' ),
            'tooltip'      => __( 'Select the items which will be shown on the left side of menu', 'componentz' ),
            'type'         => 'repeater',
            'section'      => 'componentz_menu_section',
            'row_label'    => [
                'type'  => 'field',
                'value' => esc_attr__( 'Menu Item - Left Side', 'componentz' ),
                'field' => 'media',
            ],
            'button_label' => esc_html__( 'Add new item', 'componentz' ),
            'settings'     => 'componentz_menu_items_left',
            'default'      => [
                [
                    'media' => 'side'
                ],
                [
                    'media' => 'primary'
                ]
            ],
            'choices'      => [
                'limit' => 2
            ],
            'fields'       => [
                'media' => [
                    'type'        => 'select',
                    'label'       => esc_html__( 'Select Item', 'componentz' ),
                    'description' => esc_html__( 'Select menu item', 'componentz' ),
                    'choices'     => [
                        ''        => __( '-- Select --', 'componentz' ),
                        'side'    => __( 'Side Menu', 'componentz' ),
                        'primary' => __( 'Primary Menu', 'componentz' )
                    ]
                ],
            ],
            'priority' => 5
        ] );
        Kirki::add_field( 'theme_config_id', [
            'label'        => esc_html__( 'Right Side', 'componentz' ),
            'tooltip'      => __( 'Select the items which will be shown on the right side of menu', 'componentz' ),
            'type'         => 'repeater',
            'section'      => 'componentz_menu_section',
            'row_label'    => [
                'type'     => 'field',
                'value'    => esc_attr__( 'Menu Item - Right Side', 'componentz' ),
                'field'    => 'media',
            ],
            'button_label' => esc_html__( 'Add new item', 'componentz' ),
            'settings'     => 'componentz_menu_items_right',
            'default'      => Choices::right_menu_defaults(),
            'choices'      => [
                'limit'    => count( Choices::right_menu_defaults() )
            ],
            'fields'       => [
                'media'    => [
                    'type'        => 'select',
                    'label'       => esc_html__( 'Select Item', 'componentz' ),
                    'description' => esc_html__( 'Select menu item', 'componentz' ),
                    'choices'     => Choices::right_menu_fields()
                ],
            ],
            'priority' => 6
        ] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'    => '',
            'settings' => 'componentz_mobile_menu_items_info',
            'section'  => 'componentz_menu_section',
            'type'     => 'custom',
            'default'  => '<div class="cz-info-label">' . esc_html__( 'Mobile Menu', 'componentz' ) . '</div>',
            'priority' => 7
        ] );
        Kirki::add_field( 'theme_config_id', [
            'label'        => esc_html__( 'Menu Items', 'componentz' ),
            'tooltip'      => __( 'Select the items which will be shown in the mobile menu', 'componentz' ),
            'type'         => 'repeater',
            'section'      => 'componentz_menu_section',
            'row_label'    => [
                'type'  => 'field',
                'value' => esc_attr__( 'Mobile Menu Item', 'componentz' ),
                'field' => 'media',
            ],
            'button_label' => esc_html__( 'Add new item', 'componentz' ),
            'settings'     => 'componentz_mobile_menu_items',
            'default'      => [
                [
                    'media' => 'primary'
                ]
            ],
            'choices'      => [
                'limit' => 4
            ],
            'fields'       => [
                'media' => [
                    'type'        => 'select',
                    'label'       => esc_html__( 'Select Item', 'componentz' ),
                    'description' => esc_html__( 'Select menu item', 'componentz' ),
                    'choices'     => [
                        ''        => __( '-- Select --', 'componentz' ),
                        'side'    => __( 'Side Menu', 'componentz' ),
                        'primary' => __( 'Primary Menu', 'componentz' ),
                        'social'  => __( 'Social Media Links', 'componentz' ),
                        'account' => __( 'My Account', 'componentz' )
                    ]
                ],
            ],
            'priority' => 8
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_menu_upsell',
                'section'     => 'componentz_menu_section',
                'default'     => '<div class="componentz-control-subsection">' .
                    '<ul class="componentz-upsell">' .
                    '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-header-navigation&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                    '</ul>' .
                    '</div>'
            ] );
        }

        /**
		 * Logo & Site Title [Fields]
		 ********************************************/

		Kirki::add_field( 'componentz_theme_option', [
			'label'    => esc_html__( 'Logo / Site Title', 'componentz' ),
			'tooltip'  => __( 'Select if display logo or site title', 'componentz' ),
			'settings' => 'componentz_logo_type',
			'section'  => 'componentz_logo_title_section',
			'type'     => 'select',
			'choices'  => Choices::logo_types(),
			'default'  => 'title',
            'priority' => 1
		] );
		Kirki::add_field( 'componentz_theme_option', [
			'label'           => esc_html__( 'Logo', 'componentz' ),
			'tooltip'         => __( 'Upload custom logo', 'componentz' ),
			'settings'        => 'componentz_logo',
			'section'         => 'componentz_logo_title_section',
			'type'            => 'image',
			'active_callback' => [
				[
					'setting'  => 'componentz_logo_type',
					'operator' => '==',
					'value'    => 'logo'
				]
			],
		] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'           => esc_html__( 'Logo For Menu Hover/Sticky Header', 'componentz' ),
            'tooltip'         => __( 'Upload custom logo for menu hover/sticky header', 'componentz' ),
            'settings'        => 'componentz_logo_hover',
            'section'         => 'componentz_logo_title_section',
            'type'            => 'image',
            'active_callback' => [
                [
                    'setting'  => 'componentz_logo_type',
                    'operator' => '==',
                    'value'    => 'logo'
                ]
            ],
        ] );
		Kirki::add_field( 'componentz_theme_option', [
			'label'           => esc_html__( 'Logo Max Height (px)', 'componentz' ),
			'tooltip'         => __( 'Set logo max-height in pixels', 'componentz' ),
			'settings'        => 'componentz_logo_max_height',
			'section'         => 'componentz_logo_title_section',
			'type'            => 'slider',
			'transport'       => 'auto',
			'choices'         => [
				'min'  => 10,
				'max'  => 300,
				'step' => 1
			],
			'active_callback' => [
				[
					'setting'  => 'componentz_logo_type',
					'operator' => '==',
					'value'    => 'logo'
				],
				[
					'setting'  => 'componentz_logo',
					'operator' => '!==',
					'value'    => ''
				]
			],
			'output'          => [
                [
                    'element'  => '#componentz-header .cz-logo-image',
                    'property' => 'height',
                    'suffix'   => 'px'
                ],
                [
                    'element'  => '#componentz-header .cz-logo-image',
                    'property' => 'max-height',
                    'suffix'   => 'px'
                ],
				[
					'element'  => '#componentz-header .logo-img',
					'property' => 'max-height',
					'suffix'   => 'px'
				]
			],
			'default'         => '25'
		] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'           => esc_html__( 'Sticky Logo Max Height (px)', 'componentz' ),
            'tooltip'         => __( 'Set logo max-height in pixels', 'componentz' ),
            'settings'        => 'componentz_logo_sticky_max_height',
            'section'         => 'componentz_logo_title_section',
            'type'            => 'slider',
            'transport'       => 'auto',
            'choices'         => [
                'min'  => 10,
                'max'  => 300,
                'step' => 1
            ],
            'active_callback' => [
                [
                    'setting'  => 'componentz_logo_type',
                    'operator' => '==',
                    'value'    => 'logo'
                ],
                [
                    'setting'  => 'componentz_logo',
                    'operator' => '!==',
                    'value'    => ''
                ]
            ],
            'output'          => [
                [
                    'element'  => '#componentz-header .logo-img-sticky',
                    'property' => 'max-height',
                    'suffix'   => 'px'
                ]
            ],
            'default'         => '25'
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_logo_title_upsell',
                'section'     => 'componentz_logo_title_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-logo-title&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

		/**
		 * Typography [Fields]
		 ********************************************/

        // Body
		Kirki::add_field( 'componentz_theme_option', [
			'label'     => esc_html__( 'Body Font', 'componentz' ),
			'tooltip'   => __( 'Customize the body font', 'componentz' ),
			'settings'  => 'componentz_body_typography',
			'section'   => 'componentz_typography_body_section',
			'type'      => 'typography',
			'transport' => 'auto',
            'choices'   => apply_filters( 'componentz/theme/custom_fonts', null ),
			'default'   => [
				'font-family'    => 'Lato',
				'variant'        => 'regular',
				'font-size'      => '1rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#191e27',
			],
			'output'    => [
				[
					'element' => 'body'
				]
			]
		] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_body_typo_upsell',
                'section'     => 'componentz_typography_body_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-typography-body&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

        // Header Navigation
        Kirki::add_field( 'componentz_theme_option', [
            'label'     => esc_html__( 'Header Navigation Font ( :link )', 'componentz' ),
            'tooltip'   => __( 'Customize the header navigation font', 'componentz' ),
            'settings'  => 'componentz_menu_typography',
            'section'   => 'componentz_typography_menu_section',
            'type'      => 'typography',
            'transport' => 'auto',
            'choices'   => apply_filters( 'componentz/theme/custom_fonts', null ),
            'default'   => [
                'font-family'    => 'inherit',
                'variant'        => '700',
                'font-size'      => '0.8rem',
                'color'          => '#191e27',
                'text-transform' => 'uppercase'
            ],
            'output'    => [
                [
                    'element' => '.cz-menu, 
					              .cz-menu:not(.cz-side-nav) .cz-navbar-nav .cz-nav-link, 
					              .cz-menu:not(.cz-side-nav) .cz-navbar-nav .cz-nav-link:focus, 
					              .cz-menu:not(.cz-side-nav) .cz-navbar-nav .cz-nav-link:hover, 
					              .cz-menu:not(.cz-side-nav) .cz-navbar-nav .active > .cz-nav-link, 
					              .cz-menu:not(.cz-side-nav) .cz-navbar-nav .cz-nav-link.active, 
					              .cz-menu:not(.cz-side-nav) .cz-navbar-nav .cz-nav-link.show, 
					              .cz-menu:not(.cz-side-nav) .cz-navbar-nav .show > .cz-nav-link, 
					              .cz-menu .navbar-toggler, 
					              .cz-navbar-toggler, 
					              .container-header:not(:hover):not(.hover) .cz-icon-menu, 
					              .container-header:not(:hover):not(.hover) .cz-icon-search, 
					              .container-header:not(:hover):not(.hover) .cz-icon-account, 
					              .cz-menu-right > ul li .cz-menu-link'
                ]
            ],
            'priority' => 1
        ] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'             => esc_attr__( 'Link Styling', 'componentz' ),
            'tooltip'           => esc_attr__( 'Select menu font active/hover and sticky header text color', 'componentz' ),
            'settings'          => 'componentz_menu_active_hover_color',
            'section'           => 'componentz_typography_menu_section',
            'type'              => 'multicolor',
            'transport'         => 'auto',
            'choices'           => [
                'fontactivehover'   => esc_attr__( 'Hover Color ( :hover )', 'componentz' ),
                'stickyheaderhover' => esc_attr__( 'Sticky Header Text Color', 'componentz' )
            ],
            'default'           => [
                'fontactivehover'   => '#0d55ff',
                'stickyheaderhover' => '#191e27'
            ],
            'output'            => [
                [
                    'choice'        => 'fontactivehover',
                    'element'       => '#componentz-header .container-header:hover .cz-menu:not(.cz-side-menu) .cz-navbar-nav .cz-nav-link:hover, 
                                            #componentz-header .container-header.hover .cz-menu:not(.cz-side-menu) .cz-navbar-nav .cz-nav-link:hover,
                                            #componentz-header .container-header:hover .cz-menu:not(.cz-side-menu) .cz-navbar-nav .active > .cz-nav-link,
                                            #componentz-header .container-header.hover .cz-menu:not(.cz-side-menu) .cz-navbar-nav .active > .cz-nav-link,
                                            #componentz-header .container-header:hover .cz-menu .cz-navbar-toggler:hover,
                                            #componentz-header .container-header.hover .cz-menu .cz-navbar-toggler:hover,   
                                            #componentz-header .container-header:hover .cz-menu-right ul li a:not(.cz-social-icon):not(.button):not(.remove-from-cart):not(.dropdown-product-title):not(.view-cart):not(.cz-account-link):hover,
                                            #componentz-header .container-header.hover .cz-menu-right ul li a:not(.cz-social-icon):not(.button):not(.remove-from-cart):not(.dropdown-product-title):not(.view-cart):not(.cz-account-link):hover',
                    'property'      => 'color',
                    'value_pattern' => '$ !important'
                ],
                [
                    'choice'        => 'stickyheaderhover',
                    'element'       => '#componentz-header .container-header:hover .cz-menu:not(.cz-side-menu) .cz-navbar-nav li:not(.active) .cz-nav-link,
                                            #componentz-header .container-header.hover .cz-menu:not(.cz-side-menu) .cz-navbar-nav li:not(.active) .cz-nav-link,
                                            #componentz-header .container-header:hover .cz-menu .cz-navbar-toggler,
                                            #componentz-header .container-header.hover .cz-menu .cz-navbar-toggler,                                                                                   
                                            #componentz-header .container-header:hover .cz-menu-right ul li a:not(.cz-social-icon):not(.button):not(.view-cart):not(.remove-from-cart):not(.dropdown-product-title):not(:hover):not(.button),
                                            #componentz-header .container-header.hover .cz-menu-right ul li a:not(.cz-social-icon):not(.button):not(.view-cart):not(.remove-from-cart):not(.dropdown-product-title):not(:hover):not(.button)',
                    'property'      => 'color'
                ],
            ],
            'priority' => 2
        ] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'    => '',
            'settings' => 'componentz_dropdown_menu_font_color_info',
            'section'  => 'componentz_typography_menu_section',
            'type'     => 'custom',
            'default'  => '<div class="cz-info-label">' . esc_html__( 'Dropdown Menu', 'componentz' ) . '</div>',
            'priority' => 4
        ] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'             => esc_attr__( 'Link Styling', 'componentz' ),
            'tooltip'           => esc_attr__( 'Select dropdown menu text color', 'componentz' ),
            'settings'          => 'componentz_dropdown_menu_font_color',
            'section'           => 'componentz_typography_menu_section',
            'type'              => 'multicolor',
            'transport'         => 'auto',
            'choices'           => [
                'dropdownfontcolor'      => esc_attr__( 'Color ( :link )', 'componentz' ),
                'dropdownfonthovercolor' => esc_attr__( 'Hover Color ( :hover )', 'componentz' )
            ],
            'default'           => [
                'dropdownfontcolor'      => '#191e27',
                'dropdownfonthovercolor' => '#0d55ff'
            ],
            'output'            => [
                [
                    'choice'        => 'dropdownfontcolor',
                    'element'       => '.cz-menu .cz-dropdown-item,                                            
                                            .cz-side-nav .menu-item a:not(.cz-social-icon),                                                                                         
                                            .cz-menu-right .sub-menu-item:not(.cz-social-icon):hover,
                                            #componentz-header .container-header.hover .cz-side-menu .cz-navbar-nav .cz-nav-link,
                                            #componentz-header .container-header:hover .cz-menu-right ul ul li a:not(.button):not(.view-cart):not(:hover),
                                            #componentz-header .container-header.hover .cz-menu-right ul ul li a:not(.button):not(.view-cart):not(:hover),
                                            #componentz-header .container-header:hover .cz-menu-right ul li a.dropdown-product-title,
                                            #componentz-header .container-header.hover .cz-menu-right ul li a.dropdown-product-title,
                                            .componentz-cart-dropdown',
                    'property'      => 'color',
                    'value_pattern' => '$ !important'
                ],
                [
                    'choice'        => 'dropdownfontcolor',
                    'element'       => '.componentz-cart-dropdown .toolbar-dropdown-group .cz-icon-not-found',
                    'property'      => 'fill',
                    'value_pattern' => '$'
                ],
                [
                    'choice'        => 'dropdownfonthovercolor',
                    'element'       => '.cz-menu .cz-dropdown-item:hover, 
                                            .cz-menu .cz-dropdown-item:focus,
                                            .cz-menu .menu-item .cz-dropdown-item:hover + .cz-submenu-collapse,
                                            .cz-menu .menu-item .cz-dropdown-item:focus + .cz-submenu-collapse,
                                            .cz-side-nav .menu-item .cz-submenu-collapse:hover,
                                            .cz-side-nav .menu-item .cz-submenu-collapse:focus,
                                            .cz-side-nav .menu-item a:not(.cz-social-icon):hover,                                             
                                            .cz-side-nav .menu-item a:not(.cz-social-icon):focus,
                                            .cz-side-nav .menu-item a:not(.cz-social-icon):hover + .cz-submenu-collapse,                                            
                                            .cz-side-nav .menu-item a:not(.cz-social-icon):focus + .cz-submenu-collapse,
                                            .cz-menu-right .sub-menu-item:not(.cz-social-icon):hover,
                                            .cz-menu-right .sub-menu-item:not(.cz-social-icon):focus,
                                            #componentz-header .container-header.hover .cz-side-menu .cz-navbar-nav .cz-nav-link:hover,
                                            #componentz-header .container-header.hover .cz-side-menu .cz-navbar-nav .cz-nav-link:focus,
                                            #componentz-header .container-header:hover .cz-menu-right ul ul li a:not(.cz-social-icon):not(.button):not(.view-cart):hover,
                                            #componentz-header .container-header.hover .cz-menu-right ul ul li a:not(.cz-social-icon):not(.button):not(.view-cart):hover,
                                            #componentz-header .container-header:hover .cz-menu-right ul li a.dropdown-product-title:hover,
                                            #componentz-header .container-header.hover .cz-menu-right ul li a.dropdown-product-title:hover,
                                            #componentz-header .container-header:hover .cz-menu-right ul li a.view-cart:hover,
                                            #componentz-header .container-header.hover .cz-menu-right ul li a.view-cart:hover',
                    'property'      => 'color',
                    'value_pattern' => '$ !important'
                ],
            ],
            'priority' => 4
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_menu_typo_upsell',
                'section'     => 'componentz_typography_menu_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-typography-header-navigation&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

        // Site Title
        Kirki::add_field( 'componentz_theme_option', [
            'label'           => esc_html__( 'Title Font ( :link )', 'componentz' ),
            'tooltip'         => __( 'Customize the site title font in the header area', 'componentz' ),
            'settings'        => 'componentz_site_title_typography',
            'section'         => 'componentz_typography_site_title_section',
            'type'            => 'typography',
            'transport'       => 'auto',
            'choices'         => apply_filters( 'componentz/theme/custom_fonts', null ),
            'default'         => [
                'font-family'    => 'inherit',
                'variant'        => '900',
                'font-size'      => '2rem',
                'color'          => '#191e27',
                'text-transform' => 'lowercase',
            ],
            'output'           => [
                [
                    'element'  => '#componentz-logo > h2'
                ],
                [
                    'element'  => '#componentz-logo > h2 > a'
                ]
            ],
            'priority' => 2
        ] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'             => esc_attr__( 'Link Styling', 'componentz' ),
            'tooltip'           => esc_attr__( 'Select the site title font hover color', 'componentz' ),
            'settings'          => 'componentz_site_title_typography_hover',
            'section'           => 'componentz_typography_site_title_section',
            'type'              => 'multicolor',
            'transport'         => 'auto',
            'choices'           => [
                'sitetitlehover'    => esc_attr__( 'Hover Color ( :hover )', 'componentz' ),
                'stickyheaderhover' => esc_attr__( 'Sticky Header/Hover Menu Text Color ( :link )', 'componentz' )
            ],
            'default'           => [
                'sitetitlehover'    => '#0d55ff',
                'stickyheaderhover' => '#191e27'
            ],
            'output'            => [
                [
                    'choice'        => 'sitetitlehover',
                    'element'       => '#componentz-header .container-header:hover #componentz-logo > h2 > a:hover, 
                                        #componentz-header .container-header.hover #componentz-logo > h2 > a:hover',
                    'property'      => 'color',
                    'value_pattern' => '$ !important'
                ],
                [
                    'choice'        => 'stickyheaderhover',
                    'element'       => '#componentz-header .container-header:hover #componentz-logo > h2 > a,
                                        #componentz-header .container-header.hover #componentz-logo > h2 > a,
                                        #componentz-header .container-header.header-overlay #componentz-logo > h2 > a',
                    'property'      => 'color'
                ],
            ],
            'priority' => 4
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_site_title_typo_upsell',
                'section'     => 'componentz_typography_site_title_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-typography-site-title&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

        // Header
        Kirki::add_field( 'componentz_theme_option', [
            'label'           => esc_attr__( 'Post/Page Title/Tagline Font', 'componentz' ),
            'tooltip'         => esc_attr__( 'Customize the post/page title/tagline font of the Jumbotron area', 'componentz' ),
            'settings'        => 'componentz_jumbotron_typography_header_post_title',
            'section'         => 'componentz_typography_header_section',
            'type'            => 'typography',
            'transport'       => 'auto',
            'choices'         => apply_filters( 'componentz/theme/custom_fonts', null ),
            'default'         => [
                'font-family'    => 'Lato',
                'variant'        => '900',
                'font-size'      => '6rem',
                'color'          => '#191e27',
                'text-transform' => 'none'
            ],
            'output'          => [
                [
                    'element' => '.page-title, 
                                  .page-title a'
                ]
            ],
        ] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'           => esc_attr__( 'Link Styling ( :hover )', 'componentz' ),
            'tooltip'         => esc_attr__( 'Select the post/page title/tagline font hover color', 'componentz' ),
            'settings'        => 'componentz_jumbotron_typography_hover',
            'section'         => 'componentz_typography_header_section',
            'type'            => 'color',
            'transport'       => 'auto',
            'default'         => '#0d55ff',
            'choices'         => [
                'alpha' => true,
            ],
            'output'          => [
                [
                    'element'  => '.page-title a:hover',
                    'property' => 'color',
                    'value_pattern' => '$ !important'
                ]
            ],
        ] );



        Kirki::add_field( 'componentz_theme_option', [
            'label'             => esc_attr__( 'Post/Page Meta Text Styling', 'componentz' ),
            'tooltip'           => esc_attr__( 'Customize the post/page meta text color of the Jumbotron area', 'componentz' ),
            'settings'          => 'componentz_jumbotron_typography',
            'section'           => 'componentz_typography_header_section',
            'type'              => 'multicolor',
            'transport'         => 'auto',
            'choices'           => [
                'textcolor'     => esc_attr__( 'Text Color', 'componentz' ),
                'category'      => esc_attr__( 'Categories Color ( :link )', 'componentz' ),
                'postmeta'      => esc_attr__( 'Author/Date Color ( :link )', 'componentz' ),
                'postmetahover' => esc_attr__( 'Hover Categories/Author/Date Color ( :hover )', 'componentz' )
            ],
            'default'           => [
                'textcolor'     => '#757575',
                'category'      => '#757575',
                'postmeta'      => '#757575',
                'postmetahover' => '#0d55ff'
            ],
            'output'            => [
                [
                    'choice'    => 'textcolor',
                    'element'   => '.page-header .post-meta,
                                    .post-count',
                    'property'  => 'color'
                ],
                [
                    'choice'    => 'category',
                    'element'   => '.page-header .post-meta .cat-link a, 
                                    .page-header .post-meta .cat-links a',
                    'property'  => 'color'
                ],
                [
                    'choice'    => 'postmeta',
                    'element'   => '.page-header .post-meta a',
                    'property'  => 'color'
                ],
                [
                    'choice'    => 'postmetahover',
                    'element'   => '.page-header .post-meta a:hover',
                    'property'  => 'color'
                ]
            ],
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_header_typo_upsell',
                'section'     => 'componentz_typography_header_section',
                'default'     => '<div class="componentz-control-subsection">' .
                    '<ul class="componentz-upsell">' .
                    '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-typography-header&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                    '</ul>' .
                    '</div>'
            ] );
        }

		/**
		 * Colors & Styling [Fields]
		 ********************************************/

        // Main Colors
        Kirki::add_field( 'componentz_theme_option', [
            'label'    => '',
            'settings' => 'componentz_content_link_color_info',
            'section'  => 'componentz_main_color_section',
            'type'     => 'custom',
            'default'  => '<div class="cz-info-label">' . esc_html__( 'Links', 'componentz' ) . '</div>',
            'priority' => 1
        ] );
		Kirki::add_field( 'componentz_theme_option', [
			'label'     => esc_html__( 'Body Color ( :link )', 'componentz' ),
			'tooltip'   => __( 'Set the color of body links', 'componentz' ),
			'settings'  => 'componentz_content_link_color',
			'section'   => 'componentz_main_color_section',
			'type'      => 'color',
			'transport' => 'auto',
			'default'   => '#0d55ff',
			'output'    => [
				[
					'element' => 'a,
					              .entry-content a:not(.wp-block-button__link):not(.wp-block-file__button):not(.button):not(.elementor-button):not(.edit):not(.activity-button):not(:hover)',
                    'property' => 'color'
				]
			],
            'priority' => 2
		] );
        Kirki::add_field( 'componentz_theme_option', [
            'label'     => esc_html__( 'Hover Color ( :hover )', 'componentz' ),
            'tooltip'   => __( 'Set the color of links on hover', 'componentz' ),
            'settings'  => 'componentz_link_hover_color',
            'section'   => 'componentz_main_color_section',
            'type'      => 'color',
            'transport' => 'auto',
            'default'   => '#0d55ff',
            'output'    => [
                [
                    'element' => 'a:hover,
                                  .entry-content a:hover:not(.wp-block-button__link):not(.wp-block-file__button):not(.button):not(.elementor-button):not(.edit):not(.activity-button):not(.acomment-reply):not(.acomment-delete),
                                  .entry-content a:focus:not(.wp-block-button__link):not(.wp-block-file__button):not(.button):not(.elementor-button):not(.edit):not(.activity-button):not(.acomment-reply):not(.acomment-delete),                                   
                                  #componentz-header .container-header:hover #componentz-logo > h2 > a:hover, 
                                  #componentz-header .container-header:hover .cz-menu .cz-navbar-nav .cz-nav-link:focus,
                                  #componentz-header .container-header:hover .cz-menu .cz-navbar-nav .cz-nav-link:hover,
                                  #componentz-header .container-header:hover .cz-menu .cz-navbar-nav .active > .cz-nav-link,
                                  #componentz-header .container-header:hover .cz-menu .cz-navbar-nav .cz-nav-link.active,
                                  #componentz-header .container-header:hover .cz-menu .cz-navbar-nav .cz-nav-link.show,
                                  #componentz-header .container-header:hover .cz-menu .cz-navbar-nav .show > .cz-nav-link,
                                  #componentz-header .container-header:hover .cz-menu-right ul li a:hover,
                                  #componentz-header .container-header:hover .cz-menu .cz-navbar-toggler:hover,
                                  .cz-menu.cz-side-nav .cz-navbar-nav .active > .cz-nav-link,
                                  .cz-menu .cz-dropdown-item:hover,
                                  .cz-menu .cz-dropdown-item:focus,
                                  .cz-side-nav .menu-item a:not(.cz-social-icon):hover,
                                  .cz-side-nav .menu-item a:not(.cz-social-icon):focus,                                  
                                  .cz-menu-right ul > li ul:not(.cz-dropdown-menu) li a:hover,
                                  .cz-menu-right ul > li ul:not(.cz-dropdown-menu) li a:focus,
                                  .componentz-copyright a:hover,
                                  .componentz-copyright .componentz-copyright-theme a:hover,
                                  .wp-block-archives li a:hover,
                                  .wp-block-categories li a:hover,
                                  .wp-block-latest-posts li a:hover,
                                  .wp-block-latest-comments li a:hover,
                                  .entry-title a:hover,
                                  .post-meta a:hover,
                                  .post-meta .cat-links a:hover,
                                  #featured-posts .card-title:hover,
                                  .comments-area .comment-author a:hover,
                                  .comments-area .pingback a:hover,
                                  .comments-area .trackback a:hover,
                                  .navigation a:hover,
                                  .page-links a:hover,
                                  .post-tags a:hover,
                                  .widget_recent_entries ul li a:hover,
                                  .widget_recent_comments ul li a:hover,
                                  .widget_rss ul li a:hover,
                                  .widget_archive ul li a:hover,
                                  .widget_categories ul li a:hover,
                                  .widget_meta ul li a:hover,
                                  .widget_tag_cloud a:hover,
                                  .widget_nav_menu a:hover,
                                  .widget_pages a:hover,
                                  #componentz-footer .widget_recent_entries ul li a:hover,
                                  #componentz-footer .widget_recent_comments ul li a:hover,
                                  #componentz-footer .widget_rss ul li a:hover,
                                  #componentz-footer .widget_archive ul li a:hover,
                                  #componentz-footer .widget_categories ul li a:hover,
                                  #componentz-footer .widget_meta ul li a:hover,
                                  #componentz-footer .widget_tag_cloud a:hover,
                                  #componentz-footer .widget_nav_menu a:hover,
                                  #componentz-footer .widget_pages a:hover,
                                  .woocommerce nav.woocommerce-pagination a:not(.current):hover,
                                  .woocommerce nav.woocommerce-pagination ul li a:hover,
                                  .woocommerce nav.woocommerce-pagination ul li a:focus,
                                  .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover',
                    'property' => 'color'
                ]
            ],
            'priority' => 5
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_colors_main_upsell',
                'section'     => 'componentz_main_color_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-colors-main-colors&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

        // Buttons
        Kirki::add_field( 'componentz_theme_option', [
            'label'     => esc_html__( 'Buttons Color', 'componentz' ),
            'tooltip'   => __( 'Set the buttons color', 'componentz' ),
            'settings'  => 'componentz_buttons',
            'section'   => 'componentz_colors_buttons_section',
            'type'      => 'color',
            'transport' => 'auto',
            'default'   => '#0d55ff',
            'output'    => [
                [
                    'element'  => 'button, 
                                   .button, 
                                   input[type=submit], 
                                   .wp-block-button .wp-block-button__link, 
                                   .wp-block-file .wp-block-file__button, 
                                   .woocommerce-button,
                                   .woocommerce a.edit,
                                   .woocommerce a.button,
                                   .woocommerce a.button.alt,
                                   .woocommerce a.button.disabled,
                                   .woocommerce a.button:disabled,
                                   .woocommerce a.button:disabled[disabled],
                                   .woocommerce input.button,
                                   .woocommerce input.button.alt,
                                   .woocommerce input.button.disabled,
                                   .woocommerce input.button:disabled,
                                   .woocommerce input.button:disabled[disabled],
                                   .woocommerce button.button,
                                   .woocommerce button.button.alt,
                                   .woocommerce button.button.disabled,
                                   .woocommerce button.button:disabled,
                                   .woocommerce button.button:disabled[disabled],
                                   .woocommerce button.button.alt.disabled,
                                   .woocommerce #respond input#submit,
                                   .woocommerce #respond input#submit.alt,
                                   .woocommerce #respond input#submit.disabled,
                                   .woocommerce #respond input#submit:disabled,
                                   .woocommerce #respond input#submit:disabled[disabled],
                                   body #buddypress input[type=submit],
                                   #buddypress.buddypress-wrap input[type=button],
                                   #buddypress.buddypress-wrap input[type=submit],
                                   #buddypress.buddypress-wrap a.bp-title-button,
                                   #buddypress.buddypress-wrap .comment-reply-link,
                                   #buddypress.buddypress-wrap button:not(.bp-tooltip),
                                   #buddypress.buddypress-wrap ul.button-nav:not(.button-tabs) li a,
                                   #buddypress.buddypress-wrap .notifications-options-nav input#notification-bulk-manage,
                                   #buddypress.buddypress-wrap .generic-button a:not(.bp-tooltip):not(.bp-primary-action):not(.bp-secondary-action),
                                   #buddypress.buddypress-wrap .grid.bp-list > li .action .generic-button a,
                                   #buddypress.buddypress-wrap .grid.bp-list > li .action .generic-button button,
                                   #buddypress.buddypress-wrap .activity-list .load-more a,
                                   #buddypress.buddypress-wrap .activity-list .load-newest a,
                                   #buddypress.buddypress-wrap .subnav-filters div button#user_messages_search_submit,
                                   #buddypress.buddypress-wrap .subnav-filters .user-messages-bulk-actions .bulk-apply',
                    'property' => 'background-color'
                ],
                [
                    'element'  => '.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color), 
                                   .wp-block-button.is-style-outline .wp-block-button__link:focus:not(.has-text-color), 
                                   .wp-block-button.is-style-outline .wp-block-button__link:active:not(.has-text-color)',
                    'property' => 'color'
                ]
            ],
            'priority' => 1
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_colors_buttons_upsell',
                'section'     => 'componentz_colors_buttons_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-colors-buttons&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

        /**
         * Front Page & Blog [Fields]
         ********************************************/

        Kirki::add_field( 'componentz_theme_option', [
            'label'    => esc_html__( 'Front Page Header Content - Jumbotron', 'componentz' ),
            'tooltip'  => __( 'Select what content to display in the front page header - Jumbotron', 'componentz' ),
            'settings' => 'componentz_blog_header_content',
            'section'  => 'componentz_blog_section',
            'type'     => 'select',
            'choices'  => [
                'recent'   => __( 'Recent Post', 'componentz' ),
                'sticky'   => __( 'Sticky Recent Post', 'componentz' ),
                'tagline'  => __( 'Website Tagline', 'componentz' ),
                'none'     => __( 'None', 'componentz' )
            ],
            'default' => 'recent'
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_blog_upsell',
                'section'     => 'componentz_blog_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-blog&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

		/**
		 * Social Media Links [Fields]
		 ********************************************/

		Kirki::add_field( 'theme_config_id', [
			'label'         => esc_html__( 'Social Icons', 'componentz' ),
			'type'          => 'repeater',
			'section'       => 'componentz_social_section',
			'row_label'     => [
				'type'      => 'field',
				'value'     => esc_attr__( ' Social media', 'componentz' ),
				'field'     => 'media',
			],
			'button_label'  => esc_html__( 'Add new icon', 'componentz' ),
			'settings'      => 'componentz_social_icons',
			'default'       => [
                [
                    'media'  => 'rss',
                    'url'    => esc_url_raw( get_bloginfo_rss( 'rss2_url' ) ),
                    'target' => false
                ]
            ],
			'choices'             => [
				'limit'           => count( Choices::social_icons() ) - 1
			],
			'fields'              => [
				'media'           => [
					'type'        => 'select',
					'label'       => esc_html__( 'Select Social Media', 'componentz' ),
					'description' => esc_html__( 'Select social media type', 'componentz' ),
					'choices'     => Choices::social_icons()
				],
				'url'   => [
					'type'        => 'text',
					'label'       => esc_html__( 'Page URL', 'componentz' ),
					'description' => esc_html__( 'Enter social media page url', 'componentz' )
				],
                'target' => [
                    'type'        => 'checkbox',
                    'label'       => esc_html__( 'Open url in new tab?', 'componentz' )
                ]
			]
		] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_social_upsell',
                'section'     => 'componentz_social_section',
                'default'     => '<div class="componentz-control-subsection">' .
                                 '<ul class="componentz-upsell">' .
                                 '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-social&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                                 '</ul>' .
                                 '</div>'
            ] );
        }

        /**
         * Effects & Features [Fields]
         ********************************************/

        // Page Preloader Effect
        Kirki::add_field( 'componentz_theme_option', [
            'label'     => esc_html__( 'Enable page preloader effect', 'componentz' ),
            'tooltip'   => __( 'Check the box to enable the page preloader effect', 'componentz' ),
            'settings'  => 'componentz_preloader',
            'section'   => 'componentz_page_preloader',
            'type'      => 'checkbox',
            'default'   => false
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_page_preloader_upsell',
                'section'     => 'componentz_page_preloader',
                'default'     => '<div class="componentz-control-subsection">' .
                    '<ul class="componentz-upsell">' .
                    '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-features-page-preloader&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                    '</ul>' .
                    '</div>'
            ] );
        }

        /**
         * Footer [Fields]
         ********************************************/

        Kirki::add_field( 'componentz_theme_option', [
            'label'    => esc_html__( 'Widgets Layout', 'componentz' ),
            'tooltip'  => __( 'Select the footer widgets layout', 'componentz' ),
            'settings' => 'componentz_footer_widgets_layout',
            'section'  => 'componentz_footer_section',
            'type'     => 'radio-image',
            'choices'  => [
                'twelve'                  => esc_url( get_template_directory_uri() . '/assets/img/footer-widgets-12.svg' ),
                'six-six'                 => esc_url( get_template_directory_uri() . '/assets/img/footer-widgets-6-6.svg' ),
                'four-four-four'          => esc_url( get_template_directory_uri() . '/assets/img/footer-widgets-4-4-4.svg' ),
                'three-three-three-three' => esc_url( get_template_directory_uri() . '/assets/img/footer-widgets-3-3-3-3.svg' ),
                'six-three-three'         => esc_url( get_template_directory_uri() . '/assets/img/footer-widgets-6-3-3.svg' ),
                'four-eight'              => esc_url( get_template_directory_uri() . '/assets/img/footer-widgets-4-8.svg' ),
            ],
            'default'  => 'six-six'
        ] );

        if ( ! class_exists( '\Componentz\Extras\Plugin' ) ) {
            Kirki::add_field( 'componentz_theme_option', [
                'type'        => 'custom',
                'settings'    => 'componentz_theme_footer_upsell',
                'section'     => 'componentz_footer_section',
                'default'     => '<div class="componentz-control-subsection">' .
                    '<ul class="componentz-upsell">' .
                    '<li><span class="componentz-upsell-label">'. __( 'Get More Options', 'componentz' ) .'</span> <a href="'. esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=theme-customizer-footer&utm_medium=get-more-options&utm_campaign=customizer') .'" target="_blank">'. __( 'Go Premium', 'componentz' ) .'</a></li>' .
                    '</ul>' .
                    '</div>'
            ] );
        }
	}

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */