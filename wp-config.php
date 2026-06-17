<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'renthouse_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '3G+[!7UaNgORf`$Py2a:9-O$5B}n^?2YK,c2s+/|;.daa{I^}$@u-cq:o(~[wS>^' );
define( 'SECURE_AUTH_KEY',  '&tYnmv|G;b618]AuX f6^@$@^p.PVg@f>2Yfq]lR|[8B2v0OnFl|UCsX`::W<a}G' );
define( 'LOGGED_IN_KEY',    's8OBN4n>gSHZ>.r`4z0}6n))vAQ7sZl]72N/_]-vmGz{_yx!RL!)H(0cus_ZpuW#' );
define( 'NONCE_KEY',        '[=VPcjCsObK{Y{riBp)bPp-$C9q7TJLSR--(b>_{]y~j,uO=,dlXDhTA%}sOKwRc' );
define( 'AUTH_SALT',        'FtD}qNUC1W 4Sbe$v.%kB5QQ~]^,l~!uYIULe<FRG*9/|!X1E!vn-{MP3Ep@501i' );
define( 'SECURE_AUTH_SALT', 'rKx(eGH@e2X~d(>Rg[etWWlAx_-1AW3~e4|nHrDItFRJ*7^O`({I!M+;s~XRv~a,' );
define( 'LOGGED_IN_SALT',   '%N<#02]%EjFy)`5;5}v!&p.H=s7vC?FYI5F[69N V;*)}}[e<KG6bB<5*QleJ|HP' );
define( 'NONCE_SALT',       '+[H:5NOu`0ToxtL@ploPPC.OUFX~EcQ~~ u?7T9(c_y15Qu=)T{scHf++o)9#=ER' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
