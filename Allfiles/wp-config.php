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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'technomeetup2018');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         't6a+z/dYUMWaC_#11^uT=-GC&zx6GhGiRyBLhEI*H(>I*..F>!+,.m5XD$l2[a38');
define('SECURE_AUTH_KEY',  '#N{qs6?Ti~#$(@+:J}bXY-lfvOk~k(TZgF1O SOE3{ii%K]..5|jduS7$ IwVR6H');
define('LOGGED_IN_KEY',    'pO7 euQ=Z-!)8wJPanO%sulFC*9:v(4%)6u PEU+}Is2$0%MXK[)KCWt@t49=MR*');
define('NONCE_KEY',        '):<BG+z=E4lRFzQ3usV$R};hVk=)80qIjxmu<@B3{]=H}e}(Zp`swCSPM@Lj{Qh~');
define('AUTH_SALT',        'Z+tG0z8`9K8A/rvCi|hVS)}Z ma|e.d4Z3Bu6lhJzJ/1f^Z/$`%?f+i B4|E%{pu');
define('SECURE_AUTH_SALT', '3Zo3lnc^j{*z>!~7Dt*w?Vu1@A!],$?n,o/6pA<Lj0]$PoAJUVdZ:u42GlK:aN`J');
define('LOGGED_IN_SALT',   '!f;Me5e4uWoin4;BXV9^pF9UI=v]+]*)5[,O,QTHI:i^?z#q.} WSc![LOzbxTql');
define('NONCE_SALT',       '^U^~IAq|5|#V]$&hsFEK1`V#]wiZTaiYM|#v.O:5H/Z[owv?:P=$`7;zFxM:{YeM');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
