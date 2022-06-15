<?php
/**
 * Componentz Ajax
 *
 * The main componentz Ajax class.
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

class Ajax {
    
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
        
        add_action( 'wp_ajax_install_kirki_plugin', [ $this, 'install_kirki_plugin' ] );
        add_action( 'wp_ajax_activate_kirki_plugin', [ $this, 'activate_kirki_plugin' ] );
        add_action( 'wp_ajax_activate_extras_plugin', [ $this, 'activate_extras_plugin' ] );
        
    }
    
    /**
     * Install Kirki Plugin
     *
     * Install the Kirki plugin upon request.
     *
     * @since 1.2.4
     * @access public
     * @return array
     */
    public function install_kirki_plugin() {
        $status = [
            'install' => 'plugin',
            'slug'    => 'kirki',
        ];

        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

        $api = plugins_api(
            'plugin_information',
            [
                'slug'   => 'kirki',
                'fields' => [
                    'sections' => false,
                ],
            ]
        );

        if ( is_wp_error( $api ) ) {
            $status['errorMessage'] = $api->get_error_message();
            wp_send_json_error( $status );
        }

        $skin     = new \WP_Ajax_Upgrader_Skin();
        $upgrader = new \Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );

        if ( is_wp_error( $result ) ) {
            $status['errorCode']    = $result->get_error_code();
            $status['errorMessage'] = $result->get_error_message();
            wp_send_json_error( $status );
        } elseif ( is_wp_error( $skin->result ) ) {
            $status['errorCode']    = $skin->result->get_error_code();
            $status['errorMessage'] = $skin->result->get_error_message();
            wp_send_json_error( $status );
        } elseif ( $skin->get_errors()->has_errors() ) {
            $status['errorMessage'] = $skin->get_error_messages();
            wp_send_json_error( $status );
        } elseif ( is_null( $result ) ) {
            global $wp_filesystem;

            $status['errorCode']    = 'unable_to_connect_to_filesystem';
            $status['errorMessage'] = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'componentz' );

            // Pass through the error from WP_Filesystem if one was raised.
            if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->has_errors() ) {
                $status['errorMessage'] = esc_html( $wp_filesystem->errors->get_error_message() );
            }

            wp_send_json_error( $status );
        }

        $install_status = install_plugin_install_status( $api );
        $pagenow        = isset( $_POST['pagenow'] ) ? sanitize_key( $_POST['pagenow'] ) : '';

        // If installation request is coming from import page, do not return network activation link.
        $plugins_url = ( 'import' === $pagenow ) ? admin_url( 'plugins.php' ) : network_admin_url( 'plugins.php' );

        if ( current_user_can( 'activate_plugin', $install_status['file'] ) && is_plugin_inactive( $install_status['file'] ) ) {
            $status['activateUrl'] = add_query_arg(
                [
                    '_wpnonce' => wp_create_nonce( 'activate-plugin_' . $install_status['file'] ),
                    'action'   => 'activate',
                    'plugin'   => $install_status['file'],
                ],
                $plugins_url
            );
        }

        if ( is_multisite() && current_user_can( 'manage_network_plugins' ) && 'import' !== $pagenow ) {
            $status['activateUrl'] = add_query_arg( [ 'networkwide' => 1 ], $status['activateUrl'] );
        }

        wp_send_json_success( $status );
    }
    
    /**
     * Activate Kirki Plugin
     *
     * Activate the Kirki plugin upon request.
     *
     * @since 1.2.4
     * @access public
     * @return array
     */
    public function activate_kirki_plugin() {
        if ( isset( $_POST['action'] )  && 'activate_kirki_plugin' == $_POST['action'] ) {
            $plugin = wp_normalize_path( WP_PLUGIN_DIR . '/kirki/kirki.php' );
            if ( file_exists( $plugin ) ) {
                $result = activate_plugin( 'kirki/kirki.php' );
                if ( ! is_wp_error( $result ) ) {
                    wp_send_json_success();
                } else {
                    wp_send_json_error();   
                }
            }
        }
    }
    
    /**
     * Activate Extras Plugin
     *
     * Activate componentz Extras plugin on request.
     *
     * @since 1.0.0
     * @access public
     * @return WP_Error|null
     */
    public function activate_extras_plugin() {
        if ( isset( $_POST['action'] )  && 'activate_extras_plugin' == $_POST['action'] ) {
            $plugin = wp_normalize_path( WP_PLUGIN_DIR . '/componentz-extras/componentz-extras.php' );
            if( file_exists( $plugin ) ) {
                $result = activate_plugin( 'componentz-extras/componentz-extras.php' );
                if( ! is_wp_error( $result ) ) {
                    wp_send_json_success();
                } else {
                    wp_send_json_error();
                }
            }
        }
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
