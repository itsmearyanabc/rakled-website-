<?php
/**
 * Asset loading.
 *
 * The design system is split into six small files because that is the
 * layer developers edit. Section styling is consolidated into one file
 * because the sections share most of their idioms and splitting them
 * would trade real HTTP requests for imaginary tidiness.
 *
 * Scripts are plain ES2015+ modules of a few hundred bytes each. There
 * is no framework, no animation library and no jQuery dependency.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'rc_enqueue_assets' );
/**
 * Enqueue front-end styles and scripts.
 */
function rc_enqueue_assets(): void {

	$css = array(
		'rc-tokens'     => '00-tokens.css',
		'rc-reset'      => '01-reset.css',
		'rc-typography' => '02-typography.css',
		'rc-layout'     => '03-layout.css',
		'rc-components' => '04-components.css',
		'rc-sections'   => '05-sections.css',
		'rc-motion'     => '07-motion.css',
	);

	$previous = array();

	foreach ( $css as $handle => $file ) {
		$path = RC_DIR . '/assets/css/' . $file;

		wp_enqueue_style(
			$handle,
			RC_URI . '/assets/css/' . $file,
			$previous,
			file_exists( $path ) ? (string) filemtime( $path ) : RC_VERSION
		);

		// Each file depends on the previous one, which guarantees cascade order.
		$previous = array( $handle );
	}

	// The theme stylesheet carries the header only; WordPress expects it
	// to be registered, so register it without loading a second copy.
	wp_register_style( 'rian-cullet', get_stylesheet_uri(), array(), RC_VERSION );

	$js = array( 'nav', 'reveal', 'hero', 'counters', 'process' );

	foreach ( $js as $name ) {
		$path = RC_DIR . '/assets/js/' . $name . '.js';

		if ( ! file_exists( $path ) ) {
			continue;
		}

		wp_enqueue_script(
			'rc-' . $name,
			RC_URI . '/assets/js/' . $name . '.js',
			array(),
			(string) filemtime( $path ),
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}

add_action( 'wp_head', 'rc_head_critical', 1 );
/**
 * Inline the few bytes that must run before first paint.
 *
 * The .rc-js class gates every hidden pre-reveal state in 07-motion.css.
 * Setting it here, synchronously, means that if scripting is unavailable
 * the page is never left with invisible content.
 */
function rc_head_critical(): void {
	echo "<script>document.documentElement.classList.add('rc-js');</script>\n";
}

add_filter( 'style_loader_tag', 'rc_preload_fonts', 10, 2 );
/**
 * Preload the display face used above the fold.
 *
 * @param string $tag    Link tag.
 * @param string $handle Style handle.
 * @return string
 */
function rc_preload_fonts( string $tag, string $handle ): string {

	if ( 'rc-typography' !== $handle ) {
		return $tag;
	}

	$fonts = array(
		'instrument-serif-400.woff2',
		'instrument-sans-variable.woff2',
	);

	$preloads = '';

	foreach ( $fonts as $font ) {
		if ( ! file_exists( RC_DIR . '/assets/fonts/' . $font ) ) {
			continue;
		}
		$preloads .= sprintf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( RC_URI . '/assets/fonts/' . $font )
		);
	}

	return $preloads . $tag;
}

add_action( 'enqueue_block_editor_assets', 'rc_enqueue_editor_assets' );
/**
 * Give the block editor the same tokens the front end uses, so what the
 * client sees while editing matches what visitors get.
 */
function rc_enqueue_editor_assets(): void {
	foreach ( array( '00-tokens', '02-typography', '04-components', '05-sections' ) as $file ) {
		wp_enqueue_style(
			'rc-editor-' . $file,
			RC_URI . '/assets/css/' . $file . '.css',
			array(),
			RC_VERSION
		);
	}
}
