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
define( 'AUTH_KEY',          'I`:&{Zl~O+21txHF`*SSfo@Mp&;ad-k47/G[b]_k/x6 nFp]mEJgtL%cLVuBbn`$' );
define( 'SECURE_AUTH_KEY',   '[F(^k30=viueUeIGrY4B3Q4f/!b>;9qIJ#i;_lCC$A%Zzbg7~0E;qlt&)!}Hj@7P' );
define( 'LOGGED_IN_KEY',     'M/RlDN!#Ojodzd;n EPDXvL(D?)BRQnuayP|`H<*(%i_gr%2O-X~H/]3Kv*Be>Ut' );
define( 'NONCE_KEY',         '5>CP#mD#Yr:|J0Q&qg-.D`%b7R$a%BF|rA8FwN1EC4cxY}akj5QPb1,7`wB9Gd_8' );
define( 'AUTH_SALT',         'oqey9r[ePpa0]AQEbk~Gl)?>_%eCBb,L*7!$Wm4>-EjFC&x2$8Z#B)r$c]@Upm/5' );
define( 'SECURE_AUTH_SALT',  '!LQC6f}K@s;ARVf_TNpj68ch.^Q -PNF9q1}F8# j1aWjyqb 6;G@Q;/@h(,m^Yv' );
define( 'LOGGED_IN_SALT',    '#pk%>uTlrhL5]bV+HFd@!z0y!l:I0UKZrGPXnr-nUT9u}W8RfLB=s[s1I,0Xz:{v' );
define( 'NONCE_SALT',        'M6+i$$PcZSs54JaF--QD!ye-/yG}H*`?Gk:?KGa5WCJ=.+S!703X?!mZmkB5r{:h' );
define( 'WP_CACHE_KEY_SALT', '(vw/Z#.=t?6nvc=|6xA/,Ov!UudE.qD1S@uAfzVQm<_g;uGgGC`_Q`m,uf#.T0n3' );


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
define( 'ALLOW_UNFILTERED_UPLOADS', true ); //Esto con el objetivo de poder subir los modelos gltf y gl

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
