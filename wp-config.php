<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          ':h2z97 do;&-&;h-dKYJu)zCvcX`vgOqTiJ@FlR$=mXR6`SfgF?+YO`]/!Z<okC/' );
define( 'SECURE_AUTH_KEY',   'wauW<v^k-`bqc<Yv*g*:yb>)X>dfqUblE]:_f<wg#ln=;T;LrbG&Ac>W)dmKg><)' );
define( 'LOGGED_IN_KEY',     'Wj5AjEcm-?4wVMOE,j+jn#T?tJwhb7UR(zv{)&b5$m6TbPAGc$DXdU2lEw4`;sD-' );
define( 'NONCE_KEY',         '=1g{e_.CH{{|C@^s:O<4+`]}!Y1r[F} |&GrLF>Boi6#i9<oq>g() q^)@:P0]vY' );
define( 'AUTH_SALT',         '/NJ?C-n!R[YBQ4@JhI=aQ;L@K**X5eM;b69tg<g0,WwSKMIDH<J}%9%<4|5%0Al&' );
define( 'SECURE_AUTH_SALT',  't%!92x;J/Ck(_l3)7q(7v).no xV6T<nFivYt$!nz@QSs6-<bvz8v*Lu-d(,AJ1e' );
define( 'LOGGED_IN_SALT',    '{>yeyP&-Do>~$|?0*(n1>OMOe>;8<7zA3N5 L#L0!sSEDm!dIq.gZpKMcC/#RsOy' );
define( 'NONCE_SALT',        ']tf)?-TbA19_+( X=bjPg%[q]WNU:${*~ctEGTC8OX|JDfp%RL?Pi8&}kE%p1Jq0' );
define( 'WP_CACHE_KEY_SALT', '/Yq@@!j-,10?$34+PC9+Q4-]<m*etITo.Ti#-wD29e}2F:.T^1`5eHIS#yH8ACan' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
