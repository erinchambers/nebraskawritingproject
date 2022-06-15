<?php
/**
 * Admin Setup
 *
 * The componentz admin setup class.
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

class Setup {
    
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
        
        add_action( 'tgmpa_register', [ $this, 'register_required_plugins' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_ajax_dismiss_notice', [ $this, 'dismiss_notice' ] );
        add_action( 'admin_notices', [ $this, 'notice_about' ] );
        
        /**
         * Dismiss Notice via Button
         */
        $this->dismiss_notice_button();
        
        /**
         * Include Admin Files
         *
         * @since 1.0.0
         */
        $this->get_template_parts();
        
        /**
         * Initialize Admin Classes
         *
         * @since 1.0.0
         */
        Customizer::get_instance();
    }
    
    /**
     * Enqueue Scripts
     *
     * Enqueue admin scripts.
     *
     * @since 1.0.0
     * @access public
     * @return
     */
    public function enqueue_scripts() {
        $screen = get_current_screen();
        
        // Enqueue componentz admin script.
        wp_enqueue_script( 
            'componentz-admin',
            Componentz()->uriPath( 'assets/js/admin.min.js' ), 
            [ 'jquery-ui-tabs' ], 
            Componentz()->version() 
        );
        
        // Localize componentz admin script.
        wp_localize_script( 
            'componentz-admin', 
            '_ComponentzData', 
            [
                'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) )
            ] 
        );
        
        // Enqueue componentz page stylesheet only on it's current page.
        if( 'toplevel_page_componentz' == $screen->id || 'appearance_page_componentz' == $screen->id ) {
            wp_enqueue_style( 
                'componentz-admin', 
                Componentz()->uriPath( 'assets/css/admin-style.min.css' ), 
                [], 
                Componentz()->version() 
            );
        }
        
        // Enqueue admin notice stylesheet.
        wp_enqueue_style( 
            'componentz-notice', 
            Componentz()->uriPath( 'assets/css/admin-notice.min.css' ), 
            [], 
            Componentz()->version() 
        );
        
        // Enqueue componentz font stylesheet.
        wp_enqueue_style( 
            'componentz-font', 
            Componentz()->uriPath( 'assets/css/admin-font.min.css' ), 
            [], 
            Componentz()->version() 
        );
    }
    
    /**
     * Dismiss Notice
     *
     * Dismiss notice via Ajax.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function dismiss_notice() {
        if( ! empty( $_GET['cz-hide-notice'] ) && 'about' == $_GET['cz-hide-notice'] ) {
            update_option( '_cz_dismiss_about_notice', true );
        }
        wp_die();
    }
    
    /**
     * Dismiss Notice
     *
     * Dismiss notice via  'Let's get started' button.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function dismiss_notice_button() {
        if( ! empty( $_GET['cz-hide-notice'] ) && 'about' == $_GET['cz-hide-notice'] ) {
            update_option( '_cz_dismiss_about_notice', true );
        }
    }
    
    /**
     * Notice About
     *
     * Display admin dismissible notice.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function notice_about() {
        $screen = get_current_screen();
        
        // If notice dismissed return early.
        if( get_option( '_cz_dismiss_about_notice' ) ) {
            return;
        }
        
        // Show about Componentz notice only on dashboard page.
        if( 'dashboard' == $screen->id ) {

            // If clicked on dismiss button add proper dismiss data in database.
            if( ! empty( $_GET['cz-hide-notice'] ) && 'about' == $_GET['cz-hide-notice'] ) {
                update_option( '_cz_dismiss_about_notice', true );
            }

            // Display about notice. ?>
            <div id="cz-notice-about" class="notice is-dismissible cz-notice">
                <h4>
                    <?php _e( 'Thanks for installing componentz theme', 'componentz' ); ?>
                </h4>&nbsp;&nbsp;&nbsp;
                <a href="<?php echo esc_url( admin_url( 'themes.php?page=componentz&cz-hide-notice=about' ) ); ?>" class="button button-primary"><?php _e( 'Let\'s get started', 'componentz' ); //phpcs:ignore ?></a>&nbsp;&nbsp;&nbsp;<a id="cz-about-dismiss" href="#"><?php _e( 'Dismiss', 'componentz' ); ?></a>

            </div><?php
        }
    }
    
    /**
     * Template Parts
     *
     * Include administration files.
     *
     * @since 1.0.0
     */
    private function get_template_parts() {
        
        get_template_part( 'includes/admin/class-componentz-plugin-activation' );
        get_template_part( 'includes/admin/class-componentz-menu' );
        get_template_part( 'includes/admin/customizer/class-componentz-choices' );
        if( ! class_exists( 'Componentz\Extras\Plugin' ) ) {
            get_template_part( 'includes/admin/customizer/class-componentz-premium' );
        }
        get_template_part( 'includes/admin/class-componentz-customizer' );
        
    }
    
    /**
     * Register Required Plugins
     *
     * Register the componentz theme required plugins.
     *
     * @since 1.1.8
     * @access public
     * @return array
     */
    public function register_required_plugins() {
        $plugins = [
            [
                'name'      => 'Kirki Customizer Framework',
                'slug'      => 'kirki',
                'required'  => false,
            ]
        ];

        $config = [
            'id'           => 'componentz',            // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        ];

        tgmpa( $plugins, $config );
    }

}

Setup::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
