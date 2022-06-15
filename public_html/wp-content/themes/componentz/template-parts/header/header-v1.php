<?php
/**
 * Header V1 Template
 *
 * Display Componentz header v1 template.
 *
 * @author Componentz <support@componentz.co>
 * @package Componentz
 * @subpackage Componentz Theme
 * @since 1.0.0
 */

// No direct access allowed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Left side menu settings.
$lmenus = get_theme_mod( 'componentz_menu_items_left', [
    [
        'media' => 'side'
    ],
	[
		'media' => 'primary'
	]
] );

// Mobile menu setting.
$mmenus = get_theme_mod( 'componentz_mobile_menu_items', [
    [
        'media' => 'primary'
    ]
] );

// Right side menu settings.
$rmenus = get_theme_mod( 'componentz_menu_items_right', [
    [
        'media' => 'social'  
    ],
	[
		'media' => 'search'
	],
	[
		'media' => 'account'
	]
] );

// My account URL
if( class_exists( 'Woocommerce' ) ) {
    $myaccurl = wc_get_page_permalink( 'myaccount' );
    $myordersurl = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . "orders";
} else {
    $myaccurl = get_edit_user_link();
}

?>

<div class="container-header cz-container cz-px-0">

    <?php Componentz()->get->sticky_header_background(); ?>

    <div class="cz-row cz-flex-nowrap cz-justify-content-between cz-align-items-center">

        <!-- Navbar Primary Container -->
        <div class="cz-col-2 cz-col-sm-3 cz-col-lg-4 cz-d-flex cz-justify-content-start">
            <?php foreach ( $lmenus as $lmenu ): ?>

                <?php if ( 'side' == $lmenu['media'] ): ?>
                    <nav class="cz-navbar cz-menu cz-side-nav cz-side-menu cz-px-0 cz-pl-sm-3 cz-d-none cz-d-lg-flex" role="navigation">
                        <button class="cz-navbar-toggler"
                                type="button"
                                data-toggle="cz-collapse"
                                data-target="#componentz-side-menu-collapse"
                                aria-label="<?php esc_attr_e( 'Toggle side menu', 'componentz' ); ?>"
                                aria-expanded="false"
                                aria-controls="componentz-side-menu-collapse">
                            <span class="cz-navbar-toggler-icon"><?php echo Componentz()->svg->icon( 'cz-icon-menu' ); // phpcs:ignore ?></span>
                        </button>
                        <?php Componentz()->get->menu( 'componentz_side_menu', 'side' ); ?>
                    </nav><!-- .cz-side-nav -->
                <?php endif; ?>

                <?php if ( 'primary' == $lmenu['media'] ): ?>
                    <nav class="cz-navbar cz-menu cz-primary-menu componentz-theme-menu cz-navbar-expand-lg cz-d-none cz-d-lg-flex" role="navigation">
                        <button class="cz-navbar-toggler"
                                type="button"
                                data-toggle="cz-collapse"
                                data-target="#componentz-primary-menu-collapse"
                                aria-controls="componentz-primary-menu-collapse"
                                aria-expanded="false"
                                aria-label="<?php esc_attr_e( 'Toggle navigation', 'componentz' ); ?>">
                            <span class="cz-navbar-toggler-icon"><?php echo Componentz()->svg->icon( 'cz-icon-menu' ); // phpcs:ignore ?></span>
                        </button>
                        <?php Componentz()->get->menu( 'componentz_primary_menu' ); ?>
                    </nav><!-- .cz-primary-menu -->
                <?php endif; ?>

            <?php endforeach; ?>

            <nav class="cz-navbar cz-menu cz-side-nav cz-mobile-menu cz-px-0 cz-pl-sm-3 cz-d-flex cz-d-lg-none" role="navigation">
                <button class="cz-navbar-toggler"
                        type="button"
                        data-toggle="cz-collapse"
                        data-target="#componentz-mobile-menu-collapse"
                        aria-controls="componentz-mobile-menu-collapse"
                        aria-expanded="false"
                        aria-label="<?php esc_attr_e( 'Toggle mobile menu', 'componentz' ); ?>">
                    <span class="cz-navbar-toggler-icon"><?php echo Componentz()->svg->icon( 'cz-icon-menu' ); // phpcs:ignore ?></span>
                </button>
                <div id="componentz-mobile-menu-collapse" class="cz-collapse cz-navbar-collapse">
                    <?php foreach( $mmenus as $mmenu ) : ?>

                        <?php if( 'social' == $mmenu['media'] ) : // Social Menu ?>
                        <ul class="cz-d-lg-none menu mobile-menu-social">
                            <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="cz-nav-item cz-dropdown menu-item">
                                <a href="#" id="cz-social-icons-menu-mobile" data-toggle="cz-dropdown" aria-haspopup="true" aria-expanded="false" aria-label="<?php esc_attr_e( 'Social media icons', 'componentz' ); ?>" class="cz-menu-link cz-nav-link cz-dropdown-toggle">
                                    <?php _e( 'Follow', 'componentz' ); ?>
                                    <?php echo is_rtl() ? Componentz()->svg->icon( 'cz-icon-arrow-left' ) : Componentz()->svg->icon( 'cz-icon-arrow-right' ); // phpcs:ignore ?>
                                </a>
                                <?php Componentz()->get->social_icons( 'cz-social-icons-mobile' ); ?>
                            </li>
                        </ul>
                        <?php endif; ?>

                        <?php
                        // Side Menu
                        if( 'side' == $mmenu['media'] && has_nav_menu( 'componentz_side_menu' ) ) {
                            Componentz()->get->rawMenu( 'componentz_side_menu' );
                        }

                        // Primary Menu
                        if( 'primary' == $mmenu['media'] ) {
                            Componentz()->get->rawMenu( 'componentz_primary_menu' );
                        } ?>

                        <?php if( 'account' == $mmenu['media'] ) : // Account Menu ?>
                        <ul class="cz-d-lg-none menu mobile-menu-account">
                            <?php if ( ! is_user_logged_in() ) : ?>
                                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="cz-nav-item menu-item">
                                    <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="cz-nav-link cz-dropdown-toggle cz-account-link sub-menu-item sub-menu-icon cz-login">
                                        <?php _e( 'Login', 'componentz' ); ?>
                                        <?php echo is_rtl() ? Componentz()->svg->icon( 'cz-icon-arrow-left' ) : Componentz()->svg->icon( 'cz-icon-arrow-right' ); // phpcs:ignore ?>
                                    </a>
                                </li>
                                <?php if( get_option( 'users_can_register' ) ) : ?>
                                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="cz-nav-item menu-item">
                                    <a href="<?php echo esc_url( home_url( '/wp-login.php?action=register&redirect_to=' . get_permalink() ) ); ?>" class="cz-nav-link cz-account-link sub-menu-item cz-sign-up">
                                        <?php _e( 'Sign Up', 'componentz' ); ?>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="cz-nav-item menu-item">
                                    <a href="#" class="cz-nav-link cz-account-link sub-menu-item cz-lost-password"><?php _e( 'Lost Password', 'componentz' ); ?></a>
                                </li>
                            <?php else : ?>
                                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="cz-nav-item menu-item">
                                    <a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" title="<?php esc_attr_e( 'Logout', 'componentz' ); ?>" class="cz-nav-link cz-dropdown-toggle cz-account-link sub-menu-item sub-menu-icon cz-logout">
                                        <?php _e( 'Logout', 'componentz' ); ?>
                                        <?php echo is_rtl() ? Componentz()->svg->icon( 'cz-icon-arrow-left' ) : Componentz()->svg->icon( 'cz-icon-arrow-right' ); // phpcs:ignore ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
            </nav><!-- .cz-mobile-menu -->

        </div><!-- Navbar Primary Container End -->

        <!-- Logo Container -->
        <div class="cz-col-8 cz-col-sm-6 cz-col-lg-4 cz-text-center">
            <div id="componentz-logo" class="<?php Componentz()->get->logo_wrapper_class(); ?>">
                <?php Componentz()->get->logo(); ?>
            </div>
        </div><!-- Logo Container End -->

        <!-- Right Menu Container -->
        <div class="cz-col-2 cz-col-sm-3 cz-col-lg-4 cz-d-flex cz-justify-content-end">
            <nav class="cz-navbar cz-menu cz-menu-right cz-px-0 cz-pr-sm-3" role="navigation">
                <ul class="cz-nav cz-align-items-center">
                    <?php foreach ( $rmenus as $rmenu ): ?>

                        <?php if ( 'social' == $rmenu['media'] ): ?>
                            <?php if ( Componentz()->helper->is_social_icons_active() ): ?>
                                <li class="cz-d-none cz-d-lg-block" itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                    <a href="#" id="cz-social-icons-nav" aria-label="<?php esc_attr_e( 'Social media icons', 'componentz' ); ?>" class="follow-us-dropdown cz-menu-link">
                                        <?php _e( 'Follow', 'componentz' ); ?>
                                    </a>
                                    <?php Componentz()->get->social_icons(); ?>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ( 'search' == $rmenu['media'] ) : ?>
                            <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                <a id="search-nav" class="btn-search cz-menu-link" href="#" aria-label="<?php esc_attr_e( 'Search the website', 'componentz' ); ?>">
									<?php echo Componentz()->svg->icon( 'cz-icon-search' ); // phpcs:ignore ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    
                        <?php if ( 'cart' == $rmenu['media'] && class_exists( 'Woocommerce' ) ) : ?>
                            
                            <?php 
                            if( has_action( 'componentz/theme/header_shopping_cart' ) ) {
                                /**
                                 * Hook: componentz/theme/header_shopping_cart
                                 *
                                 * @hooked none
                                 *
                                 * @since 1.0.1
                                 */
                                do_action( 'componentz/theme/header_shopping_cart' );
                            } ?>
                        
                        <?php endif; ?>

                        <?php if ( 'account' == $rmenu['media'] ) : ?>
                            <li class="cz-d-none cz-d-lg-block" itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                <a id="account-header" class="cz-menu-link" href="#" aria-label="<?php esc_attr_e( 'Toggle account menu', 'componentz' ); ?>" role="button">
                                    <?php if ( ! is_user_logged_in() ): ?>
                                        <?php echo Componentz()->svg->icon( 'cz-icon-account' ); // phpcs:ignore ?>
                                    <?php else: ?>
                                        <div class="user-avatar">
                                            <?php echo get_avatar( get_current_user_id() ); ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div id="componentz-account-menu-collapse" class="cz-navbar-collapse cz-collapse">
                                    <ul id="account-menu" class="cz-nav cz-navbar-nav">
                                        <?php if ( ! is_user_logged_in() ) : // User not logged in -> ?>
                                            <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                                <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>"
                                                   class="sub-menu-item sub-menu-icon cz-login">
                                                    <?php _e( 'Login', 'componentz' ); ?>
                                                    <?php echo is_rtl() ? Componentz()->svg->icon( 'cz-icon-arrow-left' ) : Componentz()->svg->icon( 'cz-icon-arrow-right' ); // phpcs:ignore ?>
                                                </a>
                                            </li>
                                            <?php if( get_option( 'users_can_register' ) ) : ?>
                                                <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                                    <a href="<?php echo esc_url( home_url( '/wp-login.php?action=register&redirect_to=' . get_permalink() ) ); ?>" class="sub-menu-item cz-sign-up">
                                                        <?php _e( 'Sign Up', 'componentz' ); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"><a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>" class="sub-menu-item cz-lost-password"><?php _e( 'Lost Password', 'componentz' ); ?></a>
                                            </li>
                                            <?php
                                            if( has_action( 'componentz/theme/menu/user_not_logged_in' ) ) {
                                                /**
                                                 * Hook: componentz/theme/menu/user_not_logged_in
                                                 *
                                                 * @hooked none
                                                 *
                                                 * @since 1.0.0
                                                 */
                                                do_action( 'componentz/theme/menu/user_not_logged_in' );
                                            } ?>
                                        <?php else: // User logged in -> ?>
                                            <?php
                                            if( has_action( 'componentz/theme/menu/user_logged_in' ) ) {
                                                /**
                                                 * Hook: componentz/theme/menu/user_logged_in
                                                 *
                                                 * @hooked none
                                                 *
                                                 * @since 1.0.0
                                                 */
                                                do_action( 'componentz/theme/menu/user_logged_in' );
                                            } ?>
                                            <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
                                                <a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>"
                                                   title="<?php esc_attr_e( 'Logout', 'componentz' ); ?>"
                                                   class="cz-account-link sub-menu-item sub-menu-icon cz-logout">
                                                    <?php _e( 'Logout', 'componentz' ); ?>
                                                    <?php echo is_rtl() ? Componentz()->svg->icon( 'cz-icon-arrow-left' ) : Componentz()->svg->icon( 'cz-icon-arrow-right' ); // phpcs:ignore ?>
                                                </a>
                                            </li>
                                        <?php endif; // End ! is_user_logged_in() ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </ul>
            </nav>
        </div><!-- Right Menu Container End -->

    </div>
</div>
