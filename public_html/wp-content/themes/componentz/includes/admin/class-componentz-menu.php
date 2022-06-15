<?php
/**
 * Admin Menu
 *
 * Initialize componentz admin menu.
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

class Menu {

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
        
        // Register componentz theme sub-menu in Appearance.
        add_action( 'admin_menu', [ $this, 'register_sub_menu' ] );

    }

    /**
     * Register Sub Menu
     *
     * Add a sub menu page to Appearance menu.
     *
     * @since 1.0.0
     * @access public
     * @return false|string
     */
    public function register_sub_menu() {
        if( has_action( 'componentz/theme/admin/add_theme_page' ) ) {
            /**
             * Hook: componentz/theme/admin/add_theme_page
             *
             * @hooked none
             *
             * @since 1.0.1
             */
            do_action( 'componentz/theme/admin/add_theme_page' );
        } else {
            add_theme_page(
                'Componentz',
                'Componentz',
                'edit_theme_options',
                'componentz',
                [ $this, 'page_content' ]
            );
        }
    }
    
    /**
     * Page Content
     *
     * Display Componentz admin page content.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public static function page_content() {
        $theme = wp_get_theme();
        $screen = get_current_screen();
        $changelog = Componentz()->dirPath( 'README.txt' );
        $ExtrasPlugin = wp_normalize_path( WP_PLUGIN_DIR . '/componentz-extras/componentz-extras.php' );
        $ExtrasChangelog = wp_normalize_path( WP_PLUGIN_DIR . '/componentz-extras/changelog.txt' ); ?>
        <div class="wrap about-wrap wide-width-layout componentz-wrap">

            <div class="about-title-container">

                <h1 class="about-title"><img class="about-logo" alt="<?php esc_attr_e( 'componentz', 'componentz' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/img/icons/logo.svg'; ?>"/><?php _e( 'componentz', 'componentz' ); ?><span class="cz-ml-2"><?php _e( 'Control Panel', 'componentz' ); ?></span></h1>

                <div class="support-help">
                    <a href="<?php echo esc_url( 'https://docs.componentz.co/?utm_source=componentz-about&amp;utm_medium=documentation-link&amp;utm_campaign=about-page' ); ?>"
                       class="docs button" target="_blank"><?php _e( 'Documentation', 'componentz' ); ?>
                    </a>
                </div>

            </div>

            <div id="componentz-tabs">
                <div class="nav-tabs-container">

                <ul class="nav-tab-wrapper" aria-label="<?php esc_attr_e( 'componentz menu', 'componentz' ); ?>">
                    <li class="ui-tabs-active">
                        <a href="#componentz-getstarted" class="nav-tab nav-tab-active" aria-current="page">
                            <?php echo Componentz()->svg->icon( 'cz-icon-not-found' ); // phpcs:ignore ?><?php _e( 'Get Started', 'componentz' ); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#componentz-changelog" class="nav-tab">
                            <?php echo Componentz()->svg->icon( 'cz-icon-changelog', true ); // phpcs:ignore ?><?php _e( 'Changelog', 'componentz' ); ?>
                        </a>
                    </li>

                    <?php
                    if( has_action( 'componentz/theme/admin_additional_tabs' ) ) {
                        /**
                         * Hook: componentz/theme/admin_additional_tabs
                         *
                         * @hooked none
                         *
                         * @since 1.0.0
                         */
                        do_action( 'componentz/theme/admin_additional_tabs' );
                    } ?>

                </ul>

                </div>

                <!-- Get Started -->
                <div id="componentz-getstarted" class="tab-content">
                    <div class="about-container">
                        <div class="about-row">

                            <div class="about-col product-screenshot">
                                <a href="<?php echo esc_url( 'https://componentz.co/theme/?utm_source=componentz-control-panel&amp;utm_medium=theme-homepage-link&amp;utm_campaign=about-page' ); ?>"
                                   target="_blank">
                                    <div class="screenshot-wrapper">
                                        <span class="home-page-title"><?php _e( 'Theme homepage', 'componentz' ); ?><?php echo Componentz()->svg->icon( 'cz-icon-arrow', true ); // phpcs:ignore ?></span>
                                        <img alt="<?php _e( 'componentz Theme', 'componentz' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>"/>
                                   </div>
                                </a>

                                <h4 class="product-title cz-mt-2"><?php _e( 'componentz', 'componentz' ); ?>&nbsp;&nbsp;<span class="product"><?php _e( 'Free Theme', 'componentz' ); ?></span></h4>
                                <span class="version"><?php echo __( 'Version', 'componentz' ) . ' ' . esc_html( $theme->get( 'Version' ) ); ?></span>
                                <p class="about-text">
                                    <?php _e( 'Inspired by material design, based on flexible frameworks, designed with a passion for details. The theme you were looking for if you are an advanced developer or just a web enthusiast.', 'componentz' ); ?>
                                </p>

                                <h4><?php _e( 'Spread The Love', 'componentz' ); ?></h4>
                                <p class="about-text">
                                    <?php _e( 'Do you enjoy using the theme and you would like to share it with others? We would love to see it too.', 'componentz' ); ?><br/>
                                    <a href="https://wordpress.org/support/theme/componentz/reviews/?filter=5" class="button button-terciary button-rating cz-mt-1" target="_blank">
                                        <?php echo Componentz()->svg->icon( 'cz-icon-rate', true ) . Componentz()->svg->icon( 'cz-icon-rate', true ) . Componentz()->svg->icon( 'cz-icon-rate', true ) . Componentz()->svg->icon( 'cz-icon-rate', true ) . Componentz()->svg->icon( 'cz-icon-rate', true ); // phpcs:ignore ?><?php _e( 'Rate it on wordpress.org', 'componentz' ); ?>
                                    </a>
                                </p>
                            </div>

                            <div class="about-col">
                                <h4><?php _e( 'Support & Documentation', 'componentz' ); ?></h4>
                                <p class="about-text">
                                    <?php _e( 'We\'ve created extensive documentation for all the available settings of the theme so you can learn how to set it in a not time. If you still are not able to handle it, please use our free forums support to ask any questions.', 'componentz' ); ?><br/>
                                    <a href="<?php echo esc_url( 'https://docs.componentz.co/get-started/theme-basics/?utm_source=componentz-control-panel&utm_medium=theme-basics-link&utm_campaign=about-page' ); ?>"
                                       class="button button-secondary cz-mt-1" target="_blank"><?php _e( 'Basics Docs', 'componentz' ); ?>
                                    </a>
                                    <a href="<?php echo esc_url( 'http://wordpress.org/support/theme/componentz' ); ?>"
                                       class="button cz-mt-1" target="_blank"><?php _e( 'Free Support Forums', 'componentz' ); ?>
                                    </a>
                                </p>

                                <h4><?php _e( 'Development & Child Theme', 'componentz' ); ?></h4>
                                <p class="about-text">
                                    <?php _e( 'Learn more about the theme structure and all its available functions. Begin a new project with our premade child theme which will speed up your development.', 'componentz' ); ?><br/>
                                    <a href="<?php echo esc_url( 'https://docs.componentz.co/theme-development/?utm_source=componentz-control-panel&utm_medium=theme-development-link&utm_campaign=about-page' ); ?>"
                                       class="button button-secondary cz-mt-1" target="_blank"><?php _e( 'Development Docs', 'componentz' ); ?>
                                    </a>
                                    <a href="<?php echo esc_url( 'https://docs.componentz.co/theme-development/child-theme/?utm_source=componentz-control-panel&utm_medium=theme-child-theme-link&utm_campaign=about-page' ); ?>"
                                       class="button cz-mt-1" target="_blank"><?php _e( 'Child Theme', 'componentz' ); ?>
                                    </a>
                                </p>

                                <h4><?php _e( 'Contribute', 'componentz' ); ?></h4>
                                <p class="about-text">
                                    <?php _e( 'Become a volunteer and help us in the journey by translating the theme to your language. It\'s much appreciated.', 'componentz' ); ?><br/>
                                    <a href="https://translate.wordpress.org/projects/wp-themes/componentz" class="button button-terciary cz-mt-1" target="_blank">
                                        <?php echo Componentz()->svg->icon( 'cz-icon-translate', true ); // phpcs:ignore ?><?php _e( 'Help us to translate', 'componentz' ); ?>
                                    </a>
                                </p>
                            </div>

                            <div class="about-col">
                                <h4><?php _e( 'Theme Live Customizer', 'componentz' ); ?></h4>
                                <p class="about-text">
                                    <?php _e( 'Set the theme options the way you like.', 'componentz' ); ?><br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"
                                       class="button button-secondary cz-mt-1"><?php _e( 'Start to customize', 'componentz' ); ?>
                                    </a>
                                </p>
                                    <?php if( ! class_exists( 'Kirki' ) ) : ?>
                                        <div class="blur-container">
                                            <div class="plugin-not-installed">
                                                <div class="plugin-not-installed-alert">
                                                    <h4><?php _e( 'Kirki Customizer Framework Plugin Required', 'componentz' ); ?></h4>
                                                    <p><?php _e( 'To enable all these theme options please install the Kirki Customizer Framework plugin first', 'componentz' ); ?></p>
                                                </div>
                                            </div>
                                        <div class="blur">
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=componentz_theme_layout_section' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-layout', true ); // phpcs:ignore ?><?php _e( 'Main Layout', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=header_image' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-header', true ); // phpcs:ignore ?><?php _e( 'Header', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=componentz_menu_section' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-menu', true ); // phpcs:ignore ?><?php _e( 'Header Navigation', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=componentz_logo_title_section' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-logo', true ); // phpcs:ignore ?><?php _e( 'Logo & Site Title', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=componentz_typography_panel' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-typography', true ); // phpcs:ignore ?><?php _e( 'Typography', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=componentz_colors_panel' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-colors', true ); // phpcs:ignore ?><?php _e( 'Colors & Styling', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=componentz_blog_section' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-blog', true ); // phpcs:ignore ?><?php _e( 'Front Page & Blog', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=componentz_social_section' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-social', true ); // phpcs:ignore ?><?php _e( 'Social Media Links', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=componentz_features_panel' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-features', true ); // phpcs:ignore ?><?php _e( 'Effects & Features', 'componentz' ); ?>
                                    </a>
                                    <br />
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=componentz_footer_section' ) ); ?>"
                                       class="button button-terciary cz-mt-1"><?php echo Componentz()->svg->icon( 'cz-icon-footer', true ); // phpcs:ignore ?><?php _e( 'Footer', 'componentz' ); ?>
                                    </a>
                                    <?php if( ! class_exists( 'Kirki' ) ) : ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                            </div>

                            <div class="about-col product-extension">
                                <h4 class="cz-mb-2"><?php _e( 'Recommended Plugin Extensions', 'componentz' ); ?></h4>
                                        <img alt="<?php _e( 'Kirki Customizer Framework', 'componentz' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/img/kirki-framework.jpg'; ?>"/>

                                <h4 class="product-title"><?php _e( 'Kirki Customizer Framework', 'componentz' ); ?>&nbsp;&nbsp;<span class="product"><?php _e( 'Free Plugin', 'componentz' ); ?></span></h4>

                                <?php if( class_exists( 'Kirki' ) ) : ?>
                                    <div class="cz-alert cz-alert-success cz-alert-extension cz-alert-active">
                                        <?php _e( 'Plugin active', 'componentz' ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if( ! file_exists( WP_PLUGIN_DIR . '/kirki/kirki.php' ) ) : ?>
                                    <div class="cz-alert cz-alert-warning cz-alert-extension">
                                        <?php _e( 'Plugin not installed', 'componentz' ); ?>

                                        <button type="button" class="button cz-install-kirki cz-ml-2">
                                            <span class="cz-spin"><?php echo Componentz()->svg->icon( 'cz-icon-update', true ); // phpcs:ignore ?></span><?php _e( 'Install', 'componentz' ); ?>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <?php if ( file_exists( WP_PLUGIN_DIR . '/kirki/kirki.php' ) && ! is_plugin_active( 'kirki/kirki.php' ) ) : ?>
                                    <div class="cz-alert cz-alert-warning cz-alert-extension">
                                        <?php _e( 'Plugin installed but not active', 'componentz' ); ?>

                                        <button type="button" class="button cz-activate-kirki cz-ml-2">
                                            <span class="cz-spin"><?php echo Componentz()->svg->icon( 'cz-icon-update', true ); // phpcs:ignore ?></span><?php _e( 'Activate', 'componentz' ); ?>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <p class="about-text">
                                    <?php _e( 'Kirki Customizer Framework enables all available options in the theme customizer which lets you set many useful settings.', 'componentz' ); ?>
                                </p>

                                <a href="<?php echo esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=componentz-control-panel&utm_medium=extras-plugin-homepage-link&utm_campaign=about-page' ); ?>"
                                   target="_blank">
                                        <img alt="<?php _e( 'componentz Extras', 'componentz' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/img/extras.jpg'; ?>"/>
                                </a>

                                <h4 class="product-title"><?php _e( 'componentz Extras', 'componentz' ); ?>&nbsp;&nbsp;<span class="product premium"><?php _e( 'Premium Plugin', 'componentz' ); ?></span></h4>
                                <?php if( file_exists( $ExtrasPlugin ) ) : ?>
                                    <span class="version"><?php echo __( 'Version', 'componentz' ) . ' ' . esc_html( get_option( '_ComponentzExtrasVersion' ) ); ?></span>
                                <?php endif; ?>

                                <?php if ( class_exists( 'Componentz\Extras\Plugin' ) ) : ?>
                                    <div class="cz-alert cz-alert-success cz-alert-extension cz-alert-active">
                                        <?php _e( 'Plugin active', 'componentz' ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if( ! file_exists( $ExtrasPlugin ) ) : ?>
                                    <div class="cz-alert cz-alert-warning cz-alert-extension">
                                        <?php _e( 'Plugin not installed', 'componentz' ); ?>

                                        <a href="<?php echo esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=componentz-control-panel&utm_medium=extras-learn-more-link&utm_campaign=about-page' ); ?>" target="_blank" class="button cz-ml-2">
                                            <?php _e( 'Learn More', 'componentz' ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if( file_exists( $ExtrasPlugin ) && ! class_exists( 'Componentz\Extras\Plugin' ) ) : ?>
                                    <div class="cz-alert cz-alert-warning cz-alert-extension">
                                        <?php _e( 'Plugin installed but not active', 'componentz' ); ?>

                                        <button type="button" class="button cz-ml-2 activate-extras-plugin">
                                            <span class="cz-spin"><?php echo Componentz()->svg->icon( 'cz-icon-update', true ); // phpcs:ignore ?></span><?php _e( 'Activate', 'componentz' ); ?>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <p class="about-text">
                                    <?php _e( 'componentz Extras turns the componentz theme to the next level with many great features which will help you to build an awesome site.', 'componentz' ); ?>
                                </p>

                                <?php if( class_exists( 'Componentz\Extras\Plugin' ) ) : ?>
                                    <h4><?php _e( 'Translate Plugin', 'componentz' ); ?></h4>
                                    <p class="about-text">
                                        <a href="<?php echo esc_url( 'https://docs.componentz.co/get-started/plugin-basics/plugin-translation/?utm_source=componentz-control-panel&utm_medium=extras-translate-link&utm_campaign=about-page' ); ?>" class="button button-terciary" target="_blank">
                                            <?php echo Componentz()->svg->icon( 'cz-icon-translate', true ); // phpcs:ignore ?><?php _e( 'Help us to translate', 'componentz' ); ?>
                                        </a>
                                    </p>

                                    <h4><?php _e( 'Support', 'componentz' ); ?></h4>
                                    <a href="<?php echo esc_url( 'https://componentz.co/forums/forum/componentz-theme/?utm_source=componentz-control-panel&utm_medium=extras-support-forums-link&utm_campaign=about-page' ); ?>"
                                       class="button" target="_blank"><?php _e( 'Premium Support Forums', 'componentz' ); ?>
                                    </a>

                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Get Started End -->

                <!-- Changelog -->
                <div id="componentz-changelog" class="tab-content">
                    <div class="about-container">
                        <div class="about-row">
                            <div class="changelog-col">
                                <h4 class="product-title product-title-changelog"><?php _e( 'componentz', 'componentz' ); ?>&nbsp;&nbsp;<span class="product"><?php _e( 'Free Theme', 'componentz' ); ?></span></h4>
                                <div class="about-text">
                                    <div id="cz-changelog" class="cz-changelog"><?php
                                        $allowed_html = [
                                            'h4' => [],
                                            'p' => [],
                                            'svg' => [
                                                'class' => [],
                                                'aria-hidden' => [],
                                                'role' => []
                                            ],
                                            'use' => [
                                                'xlink:href' => []
                                            ],
                                            'path' => [
                                                'd' => []
                                            ]
                                        ];
                                        if( is_readable( $changelog ) ):
                                            $parts = new \SplFileObject( $changelog );
                                            $parts = new \LimitIterator($parts, 79);
                                            foreach( $parts as $line ) :
                                                $line = esc_html( $line );
                                                $line = preg_replace( '/^= (.*?) =/', '<h4>$1</h4>', $line );
                                                if( ! preg_match( '/<h4>/', $line ) ) {
                                                    $line = '<p>' . $line;
                                                }
                                                if( ! preg_match( '/<\/h4>/', $line ) ) {
                                                    $line = '</p>' . $line;
                                                }
                                                $line = str_replace( '[new]', Componentz()->svg->icon( 'cz-icon-ok', true ), $line ); // phpcs:ignore
                                                $line = str_replace( '[updated]', Componentz()->svg->icon( 'cz-icon-update', true ), $line ); // phpcs:ignore
                                                $line = str_replace( '[fixed]', Componentz()->svg->icon( 'cz-icon-fix', true ), $line ); // phpcs:ignore
                                                $line = str_replace( '[improved]', Componentz()->svg->icon( 'cz-icon-fix', true ), $line ); // phpcs:ignore
                                                echo wp_kses( $line, $allowed_html );
                                            endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="changelog-col">
                                <h4 class="product-title product-title-changelog"><?php _e( 'componentz Extras', 'componentz' ); ?>&nbsp;&nbsp;<span class="product premium"><?php _e( 'Premium Plugin', 'componentz' ); ?></span></h4>

                                <div class="about-text">
                                    
                                    <?php if( ! file_exists( $ExtrasPlugin ) ) : ?>
                                    <div class="cz-alert cz-alert-warning cz-alert-extension">
                                        <?php _e( 'Plugin not installed', 'componentz' ); ?>

                                        <a href="<?php echo esc_url( 'https://componentz.co/theme/componentz-extras/?utm_source=componentz-control-panel&utm_medium=extras-learn-more-link&utm_campaign=about-page' ); ?>" target="_blank" class="button cz-m-0 cz-ml-2">
                                            <?php _e( 'Learn More', 'componentz' ); ?>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if( file_exists( $ExtrasPlugin ) && ! class_exists( 'Componentz\Extras\Plugin' ) ) : ?>
                                    <div class="cz-alert cz-alert-warning cz-alert-extension">
                                        <?php _e( 'Plugin installed but not active', 'componentz' ); ?>

                                        <button type="button" class="button cz-m-0 cz-ml-2 activate-extras-plugin">
                                            <span class="cz-spin"><?php echo Componentz()->svg->icon( 'cz-icon-update', true ); // phpcs:ignore ?></span><?php _e( 'Activate', 'componentz' ); ?>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if( class_exists( 'Componentz\Extras\Plugin' ) ) : ?>
                                    <div id="cz-extras-changelog" class="cz-changelog"><?php
                                        $allowed_html = [
                                            'h4' => [],
                                            'p' => [],
                                            'svg' => [
                                                'class' => [],
                                                'aria-hidden' => [],
                                                'role' => []
                                            ],
                                            'use' => [
                                                'xlink:href' => []
                                            ],
                                            'path' => [
                                                'd' => []
                                            ]
                                        ];
                                        if( file_exists( $ExtrasChangelog ) && is_readable( $ExtrasChangelog ) ) :
                                            $parts = new \SplFileObject( $ExtrasChangelog );
                                            $parts = new \LimitIterator($parts, 0);
                                            foreach( $parts as $line ) :
                                                $line = esc_html( $line );
                                                $line = preg_replace( '/=(.*?)=/', '<h4>$1</h4>', $line );
                                                if( ! preg_match( '/<h4>/', $line ) ) {
                                                    $line = '<p>' . $line;
                                                }
                                                if( ! preg_match( '/<\/h4>/', $line ) ) {
                                                    $line = '</p>' . $line;
                                                }
                                                $line = str_replace( '[new]', Componentz()->svg->icon( 'cz-icon-ok', true ), $line ); // phpcs:ignore
                                                $line = str_replace( '[updated]', Componentz()->svg->icon( 'cz-icon-update', true ), $line ); // phpcs:ignore
                                                $line = str_replace( '[fixed]', Componentz()->svg->icon( 'cz-icon-fix', true ), $line ); // phpcs:ignore
                                                $line = str_replace( '[improved]', Componentz()->svg->icon( 'cz-icon-fix', true ), $line ); // phpcs:ignore
                                                echo wp_kses( $line, $allowed_html );
                                            endforeach;
                                        endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Changelog End -->

                <?php
                if( has_action( 'componentz/theme/admin_additional_content' ) ) {
                    /**
                     * Hook: componentz/theme/admin_additional_content
                     *
                     * @hooked none
                     *
                     * @since 1.0.0
                     */
                    do_action( 'componentz/theme/admin_additional_content' );
                } ?>

            </div>

        </div>
        <?php
    }

}

Menu::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */