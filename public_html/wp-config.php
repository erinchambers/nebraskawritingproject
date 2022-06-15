<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nebraska_wp1' );

/** MySQL database username */
define( 'DB_USER', 'nebraska_wp1' );

/** MySQL database password */
define( 'DB_PASSWORD', 'P.IuFdSakzQEqzEY79I11' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ZAkNNm9eFO1vFtp5LfqLx1QxrXW1t1o8uWkWZv2zTUwML1SiwIVa4v7oCWbC18lP');
define('SECURE_AUTH_KEY',  'AB16a8Qr2pMPDf2aFZ6P71H6p95oUDrBhOyGBQkK59bmZL7AWC72DZHGl5wgPjer');
define('LOGGED_IN_KEY',    'apT4tttvbuFVKTZWwH87sfW743XQgdGzoBx4Wha9SnKckEYtEQZIQHW7tIP8398O');
define('NONCE_KEY',        'rYSKWvY5dO02P0CEDudaU98aMhGx4CIoZykCiXZUO2IlZ5IqZPM9X3An6trKaPZ2');
define('AUTH_SALT',        'jUyPoq5hAtPZER6WuGk1EUtyfhxxoGK4inLux9slBs0IMGAGpcoe4HMbuMoKzhV0');
define('SECURE_AUTH_SALT', '7j36Dh7aLOgPBEHamFUdb3Ew0atTbNbtNKQYfjBX7khMCQjIKNjtsTMNkyrbMYsj');
define('LOGGED_IN_SALT',   '6rslj5DQp4F6WR0FWZJgSUlbMpAnzLWWYDBb5bBTicpZllUIAHvtC9N7CIinU9Fn');
define('NONCE_SALT',       '6q91CjE08P88lQlWH2qreii5UTb7iZfRW4x88a60QfWqPf5g9ZgvnAQdN7kTGAxf');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';