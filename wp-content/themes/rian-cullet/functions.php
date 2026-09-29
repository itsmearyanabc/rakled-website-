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

define( 'RC_VERSION', '1.1.0' );
define( 'RC_DIR', get_template_directory() );
define( 'RC_URI', get_template_directory_uri() );

/**
 * Company facts, as supplied by the client. Every figure on the site
 * reads from these, so a correction is made once, here.
 */
define( 'RC_FOUNDED', 1996 );
define( 'RC_COMBINED_EXPERIENCE', 65 ); // Years, combined across the team.
define( 'RC_COMPANIES_SERVED', 35 );
define( 'RC_STATES_SERVED', 22 );

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
