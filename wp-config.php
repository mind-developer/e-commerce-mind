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
define( 'DB_NAME', 'ecommercemind_wp_ae3mj' );

/** MySQL database username */
define( 'DB_USER', 'ecommercemind_wp_feqnd' );

/** MySQL database password */
define( 'DB_PASSWORD', '4_aFnPVkrNRa3B9%' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '0|9r]#stv_cq932d6t|Ai1yizl667;562;nOSWFZ797[PPc-0)s(k[ZLjpbtN]4m');
define('SECURE_AUTH_KEY', '8HV65@&3*[-cJH2a+_33ekOO929*7[6HOk4qY*1tx5&t3v||5EF@)#&g5c:*8U#2');
define('LOGGED_IN_KEY', 'z6~(i7/d@|V7g3(!8#0r_-rN!9l438b2:BY6sO_E4n57_(Vh|vxd76F/44R*~kK2');
define('NONCE_KEY', 't;&sQ@|[E58d%6D5j8h21~_lSd81&r7XxyLY@laxIG+Jy|+53+9e+2Cur@-)a1ih');
define('AUTH_SALT', '!Qw#7O1RLR2;9E6aq9q)RI[ZKzwoe-w4]%3g06*L(2%fVXf1VmD[!4WDboArCni1');
define('SECURE_AUTH_SALT', '-Kkx2UYYE3V3T52cK3)mH6KQz(*61~)J5]7n9_%8A;i|Cw5i5WLA!1]2k_b)59!:');
define('LOGGED_IN_SALT', 'X0oT-6%q:99c0gV73-&Q126)h29zF;vD9/l3((jWE8GR|x9Y9|19Mn/w4OTCx[JD');
define('NONCE_SALT', '(7#(2*V)UaSCZbd11s%-4YN57l]13Q]Ro]QC|AgT445&2OH2/C04_t9x/F3JpCTt');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'RxlJrQKPm_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
