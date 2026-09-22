<?php
/**
 * Homepage.
 *
 * The homepage is a fixed visual narrative rather than a free-form page,
 * so it is composed from template parts in a deliberate order:
 *
 *   glass -> waste -> recovery -> sorting -> processing -> cullet
 *   -> manufacturing -> circularity
 *
 * Each part is self-contained and carries its own copy, so sections can
 * be reordered or removed by editing this file alone.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

get_header();

$rc_sections = array(
	'hero',
	'stats',
	'intro',
	'process',
	'product',
	'colour',
	'why',
	'founder',
	'heritage',
	'sustainability',
	'cta',
	'contact',
);

foreach ( $rc_sections as $rc_section ) {
	get_template_part( 'template-parts/sections/' . $rc_section );
}

get_footer();
