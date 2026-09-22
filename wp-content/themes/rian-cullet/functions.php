<?php
/**
 * Rian Cullet theme bootstrap.
 *
 * Each concern lives in its own file under inc/. Nothing but wiring
 * belongs here.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

define( 'RC_VERSION', '1.0.0' );
define( 'RC_DIR', get_template_directory() );
define( 'RC_URI', get_template_directory_uri() );

/**
 * The year the company was established. Every "years of experience"
 * figure on the site is derived from this constant so the number can
 * never drift out of date.
 */
define( 'RC_FOUNDED', 1995 );

require_once RC_DIR . '/inc/helpers.php';
require_once RC_DIR . '/inc/setup.php';
require_once RC_DIR . '/inc/enqueue.php';
require_once RC_DIR . '/inc/seo.php';
require_once RC_DIR . '/inc/schema.php';
require_once RC_DIR . '/inc/enquiry-form.php';
require_once RC_DIR . '/inc/patterns.php';
require_once RC_DIR . '/inc/customizer.php';

if ( is_admin() ) {
	require_once RC_DIR . '/inc/starter-content.php';
}
