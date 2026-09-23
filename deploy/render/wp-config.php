<?php
/**
 * WordPress configuration for the Render container.
 *
 * Staging only. The live site (Hostinger) gets its own wp-config from
 * the host's installer; nothing here is meant to travel there.
 *
 * @package RianCullet
 */

// SQLite, via the drop-in in wp-content/db.php. The MySQL constants are
// required by core but unused. The database lives outside the web root.
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', '' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', '' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
define( 'DB_DIR', '/var/www/data/' );
define( 'DB_FILE', '.ht.sqlite' );

// Render terminates TLS and forwards plain HTTP. Without this, WordPress
// believes it is on http:// and redirect-loops on wp-admin.
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && str_contains( $_SERVER['HTTP_X_FORWARDED_PROTO'], 'https' ) ) {
	$_SERVER['HTTPS'] = 'on';
}

// The site was installed at build time, before its URL was known, so the
// address is taken from the request. Render only routes a service's own
// domains to it, so the Host header is always one of them. WP-CLI has no
// request, and falls back to Render's URL for the service.
if ( ! empty( $_SERVER['HTTP_HOST'] ) ) {
	$rc_url = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['HTTP_HOST'];
} else {
	$rc_url = (string) getenv( 'RENDER_EXTERNAL_URL' );
}

if ( '' !== $rc_url ) {
	define( 'WP_HOME', $rc_url );
	define( 'WP_SITEURL', $rc_url );
}

// Generated once per container by start.sh, never committed.
require '/var/www/data/salts.php';

// No installing or editing plugins and themes from wp-admin. Core files
// are read-only to the web server anyway; this keeps wp-admin honest
// about it, and removes the usual route from a stolen login to code.
define( 'DISALLOW_FILE_MODS', true );
define( 'DISALLOW_FILE_EDIT', true );

define( 'WP_ENVIRONMENT_TYPE', 'staging' );
define( 'WP_DEBUG', false );

$table_prefix = 'wp_';

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
