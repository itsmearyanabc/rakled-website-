<?php
/**
 * Theme supports, menus and image sizes.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'rc_theme_setup' );
/**
 * Register theme features.
 */
function rc_theme_setup(): void {

	load_theme_textdomain( 'rian-cullet', RC_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );

	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	// The mark beside the wordmark can be replaced from Site Identity.
	// Upload the mark alone, not a lockup with lettering: see rc_logo_mark().
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 192,
			'width'       => 192,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// The design has no decorative header image or custom background;
	// both are deliberately omitted so the editor cannot break the system.

	add_editor_style( 'assets/css/editor.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'rian-cullet' ),
			'footer'  => __( 'Footer Navigation', 'rian-cullet' ),
		)
	);

	/*
	 * Image sizes match the aspect ratios declared in the CSS so that
	 * WordPress crops to the design rather than the design bending to
	 * whatever WordPress produced.
	 */
	add_image_size( 'rc-hero',      2560, 1440, true ); // 16:9
	add_image_size( 'rc-hero-sm',   1080, 1350, true ); // 4:5  mobile hero
	add_image_size( 'rc-portrait',  1200, 1500, true ); // 4:5
	add_image_size( 'rc-panel',     1200, 1600, true ); // 3:4
	add_image_size( 'rc-editorial', 1800, 1200, true ); // 3:2
}

add_filter( 'body_class', 'rc_body_class' );
/**
 * Add a template-specific body class.
 *
 * @param string[] $classes Existing classes.
 * @return string[]
 */
function rc_body_class( array $classes ): array {
	// Not "rc-body": that is the paragraph style in 02-typography.css,
	// and on <body> its 68ch max-width squeezed the whole site into one
	// narrow column.
	$classes[] = 'rc-site';
	if ( is_front_page() ) {
		$classes[] = 'rc-page-home';
	}
	return $classes;
}

add_action( 'wp_head', 'rc_favicons', 3 );
add_action( 'login_head', 'rc_favicons' );
/**
 * Favicons from the brand mark.
 *
 * A Site Icon set under Appearance > Customize > Site Identity wins;
 * WordPress prints that itself, so this stands down.
 */
function rc_favicons(): void {

	if ( has_site_icon() ) {
		return;
	}

	$icons = array(
		array( 'favicon-32', 'icon', '32x32' ),
		array( 'favicon-192', 'icon', '192x192' ),
		array( 'apple-touch-icon', 'apple-touch-icon', '180x180' ),
	);

	foreach ( $icons as [ $name, $rel, $sizes ] ) {
		$sources = rc_image_sources( $name );

		if ( isset( $sources['png'] ) ) {
			printf(
				'<link rel="%1$s" href="%2$s" sizes="%3$s" type="image/png">' . "\n",
				esc_attr( $rel ),
				esc_url( $sources['png'] ),
				esc_attr( $sizes )
			);
		}
	}
}

/**
 * Strip the emoji script. It is 10KB of JavaScript this site never uses.
 */
add_action(
	'init',
	static function (): void {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'rsd_link' );
	}
);

/**
 * Remove the global block-library inline SVG sprite and classic theme
 * styles the design never uses.
 */
add_action(
	'wp_enqueue_scripts',
	static function (): void {
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
	},
	20
);
