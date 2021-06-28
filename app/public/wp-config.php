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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'cUaoNVPMHFmdughDHykGmqwNgcmT2S8p8RLTdQHzCJRI9oKafij23TsqGpNcoz8ott2tEjcPP4NwGMobZ5hdYQ==');
define('SECURE_AUTH_KEY',  'MrhCGDOYMczh0kkAse1E8+b0kWMpBWXyASZhi/O+9PW0KFxuuuemSm+kofU7WdUdvEROtefgToj3Yt9XuOuK2g==');
define('LOGGED_IN_KEY',    'ViO8HNuk1jk15r3kHUnjPinAt+1gwsPLBLp4YFAmHy5jZQwOgGLOfmBuwLycCb+EzqMYu83RwCtL3QHcYIh/+A==');
define('NONCE_KEY',        '83vxor4Wol1SGol0qEB2hpDQ3hVjL+luQyB81SZGymZkjm3YyeWRWiTEU5ElwElxnjwgdNKAbsT+/puLo7EYvQ==');
define('AUTH_SALT',        'SswNlXVVOGCa3At0foGcs9Ohk0HtQI0/oPiuU4w/9FthiT/NbuzVeQRx2CFbjxZVY9Jb9XPncF/wSKlRCZZtgQ==');
define('SECURE_AUTH_SALT', 'zlaWdKZH7asFcklt8/HnGHve2FXC9EGF7Leb4p/5eeJKPqhkgwD71ZmHcKtgTpJoLBHJxUpoD1CvQ6dEwsBBvQ==');
define('LOGGED_IN_SALT',   'WFeyVQZAFsfM4P8CpLZEhBzSF1f/CxFuFjOdcjm/49VrgXxzN0p+njctF5AlhkKdTnbYJIoVXOkmRbqyeljcfQ==');
define('NONCE_SALT',       'KZkuokBIB/+wu3LAngbyuvWbeErkNMjbj7XYtziQ7qiF38OL+cQH6HiqeBKSIqP1CgInzXn8CX6usWUR6JZDdg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
