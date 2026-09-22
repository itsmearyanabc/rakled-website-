<?php
/**
 * Block editor configuration.
 *
 * The homepage narrative is built from PHP template parts rather than
 * patterns, because those sections resolve their imagery at render time
 * through rc_figure(). A pattern freezes its markup into the post the
 * moment it is inserted, which would nail today's placeholder into the
 * database and break the drop-in replacement the brief asks for.
 *
 * Inner page body copy is ordinary block content, so the editor is
 * constrained here to the brand palette instead of being left open.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'rc_register_pattern_category' );
/**
 * Register the theme pattern category.
 */
function rc_register_pattern_category(): void {

	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'rian-cullet',
		array( 'label' => __( 'Rian Cullet', 'rian-cullet' ) )
	);
}

add_action( 'after_setup_theme', 'rc_trim_core_patterns' );
/**
 * Remove the bundled core patterns.
 *
 * They carry their own typography and colour decisions, and every one
 * of them inserted into this site would arrive off-brand.
 */
function rc_trim_core_patterns(): void {
	remove_theme_support( 'core-block-patterns' );
}

add_filter( 'block_editor_settings_all', 'rc_lock_editor_settings' );
/**
 * Keep the editor inside the design system.
 *
 * @param array<string, mixed> $settings Editor settings.
 * @return array<string, mixed>
 */
function rc_lock_editor_settings( array $settings ): array {
	$settings['disableCustomColors']     = true;
	$settings['disableCustomFontSizes']  = true;
	$settings['disableCustomGradients']  = true;
	return $settings;
}
