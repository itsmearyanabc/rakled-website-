<?php
/**
 * Customizer settings.
 *
 * Only the details the brief did not supply live here. Phone and email
 * were never provided, so rather than inventing them the theme exposes
 * them as settings and simply renders nothing until they are filled in.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', 'rc_customize_register' );
/**
 * Register theme settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function rc_customize_register( $wp_customize ): void {

	$wp_customize->add_section(
		'rc_contact',
		array(
			'title'       => __( 'Rian Cullet: contact details', 'rian-cullet' ),
			'priority'    => 30,
			'description' => __( 'Left blank, these are omitted from the site and from the structured data rather than shown as placeholders.', 'rian-cullet' ),
		)
	);

	$wp_customize->add_setting(
		'rc_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'rc_phone',
		array(
			'label'       => __( 'Public phone number', 'rian-cullet' ),
			'section'     => 'rc_contact',
			'type'        => 'text',
			'description' => __( 'Include the country code, for example +91 11 0000 0000.', 'rian-cullet' ),
		)
	);

	$wp_customize->add_setting(
		'rc_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'rc_email',
		array(
			'label'   => __( 'Public enquiry email', 'rian-cullet' ),
			'section' => 'rc_contact',
			'type'    => 'email',
		)
	);
}
