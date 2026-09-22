<?php
/**
 * Template helpers.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

/**
 * Years of operation, derived from the founding year.
 *
 * Never hard-code this figure in a template. Deriving it means the site
 * cannot silently start advertising the wrong number of years.
 *
 * @return int
 */
function rc_years_of_experience(): int {
	return (int) ( (int) current_time( 'Y' ) - RC_FOUNDED );
}

/**
 * The registered address, as structured parts.
 *
 * Held in one place so the contact section, the footer and the
 * LocalBusiness schema can never disagree with each other.
 *
 * @return array<string, string>
 */
function rc_address(): array {
	return array(
		'street'   => 'Khasra No. 45/23, 8 Tikri Kalan',
		'locality' => 'Delhi',
		'postcode' => '110041',
		'country'  => 'IN',
		'country_name' => 'India',
	);
}

/**
 * Contact channels that the client has supplied.
 *
 * Phone and email are intentionally empty. They were not provided in the
 * brief and are NOT invented here. Populate them in the Customizer, or
 * filter 'rc_contact_channels'. Every template checks before printing, so
 * an empty value simply renders nothing rather than a placeholder.
 *
 * @return array<string, string>
 */
function rc_contact_channels(): array {
	$channels = array(
		'phone' => (string) get_theme_mod( 'rc_phone', '' ),
		'email' => (string) get_theme_mod( 'rc_email', '' ),
	);

	/**
	 * Filters the public contact channels.
	 *
	 * @param array<string, string> $channels Phone and email.
	 */
	return (array) apply_filters( 'rc_contact_channels', $channels );
}

/**
 * Resolve a theme image to the best format available on disk.
 *
 * Looks for <name>.avif, <name>.webp and <name>.jpg in assets/img/ and
 * returns only the ones that exist. This is what makes the placeholder
 * system work: drop the real photograph in and it is picked up with no
 * template change.
 *
 * @param string $name Filename without extension.
 * @return array<string, string> Extension => URL.
 */
function rc_image_sources( string $name ): array {
	$found = array();

	foreach ( array( 'avif', 'webp', 'jpg', 'jpeg', 'png' ) as $ext ) {
		$path = RC_DIR . '/assets/img/' . $name . '.' . $ext;
		if ( file_exists( $path ) ) {
			$found[ $ext ] = RC_URI . '/assets/img/' . $name . '.' . $ext;
		}
	}

	return $found;
}

/**
 * Render a responsive figure, or a clearly-labelled placeholder.
 *
 * @param array{
 *     name:string, alt:string, ratio?:string, class?:string,
 *     note?:string, priority?:bool, width?:int, height?:int
 * } $args Arguments.
 */
function rc_figure( array $args ): void {

	$args = wp_parse_args(
		$args,
		array(
			'name'     => '',
			'alt'      => '',
			'ratio'    => 'rc-ratio-editorial',
			'class'    => '',
			'note'     => '',
			'priority' => false,
			'width'    => 1600,
			'height'   => 1067,
			'tag'      => 'figure',
		)
	);

	// Callers that supply their own <figcaption> wrap this in an outer
	// <figure> and pass 'div', so figures are never nested.
	$tag = in_array( $args['tag'], array( 'figure', 'div' ), true ) ? $args['tag'] : 'figure';

	$classes = trim( 'rc-figure ' . $args['ratio'] . ' ' . $args['class'] );
	$sources = rc_image_sources( $args['name'] );

	// No asset on disk yet: render the labelled placeholder instead.
	if ( empty( $sources ) ) {
		printf(
			'<div class="%1$s rc-placeholder" role="img" aria-label="%2$s">
				<span class="rc-placeholder__name">%3$s</span>
				<span class="rc-placeholder__note">%4$s</span>
			</div>',
			esc_attr( $classes ),
			esc_attr( $args['alt'] ),
			esc_html( $args['name'] . '.webp' ),
			esc_html( $args['note'] ? $args['note'] : __( 'Awaiting photography', 'rian-cullet' ) )
		);
		return;
	}

	$fallback = $sources['jpg'] ?? $sources['jpeg'] ?? $sources['png'] ?? reset( $sources );

	echo '<' . $tag . ' class="' . esc_attr( $classes ) . '">';
	echo '<picture>';

	foreach ( array( 'avif' => 'image/avif', 'webp' => 'image/webp' ) as $ext => $type ) {
		if ( isset( $sources[ $ext ] ) ) {
			printf(
				'<source srcset="%1$s" type="%2$s">',
				esc_url( $sources[ $ext ] ),
				esc_attr( $type )
			);
		}
	}

	printf(
		'<img src="%1$s" alt="%2$s" width="%3$d" height="%4$d" %5$s>',
		esc_url( $fallback ),
		esc_attr( $args['alt'] ),
		(int) $args['width'],
		(int) $args['height'],
		$args['priority']
			? 'loading="eager" fetchpriority="high" decoding="async"'
			: 'loading="lazy" decoding="async"'
	);

	echo '</picture>';
	echo '</' . $tag . '>';
}

/**
 * Print the brand mark that sits beside the typographic wordmark.
 *
 * Only the mark is used, never the full lockup: the header turns dark
 * over the hero and over every dark section, and the lockup's navy and
 * green lettering disappears on those surfaces. The mark reads on all
 * of them, and the company name beside it is live text that inverts
 * with the surface like the rest of the header.
 *
 * A logo chosen under Appearance > Customize > Site Identity takes
 * precedence over the file in assets/img/. The image is decorative
 * (empty alt) because the surrounding link already names the company.
 *
 * @param string $loading 'eager' in the header, 'lazy' in the footer.
 */
function rc_logo_mark( string $loading = 'eager' ): void {

	if ( has_custom_logo() ) {
		echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput
			(int) get_theme_mod( 'custom_logo' ),
			'medium',
			false,
			array(
				'class'    => 'rc-wordmark__mark',
				'alt'      => '',
				'loading'  => $loading,
				'decoding' => 'async',
			)
		);
		return;
	}

	$sources = rc_image_sources( 'logo-mark' );

	if ( ! $sources ) {
		return;
	}

	$ext      = isset( $sources['png'] ) ? 'png' : (string) array_key_first( $sources );
	$fallback = $sources[ $ext ];
	$size     = wp_getimagesize( RC_DIR . '/assets/img/logo-mark.' . $ext );

	echo '<picture class="rc-wordmark__mark">';

	if ( isset( $sources['webp'] ) && 'webp' !== $ext ) {
		printf( '<source srcset="%s" type="image/webp">', esc_url( $sources['webp'] ) );
	}

	printf(
		'<img src="%1$s" alt="" width="%2$d" height="%3$d" loading="%4$s" decoding="async">',
		esc_url( $fallback ),
		(int) ( $size[0] ?? 0 ),
		(int) ( $size[1] ?? 0 ),
		'lazy' === $loading ? 'lazy' : 'eager'
	);

	echo '</picture>';
}

/**
 * Render a button or button-styled link.
 *
 * @param array{
 *     label:string, url?:string, variant?:string, arrow?:bool,
 *     type?:string, class?:string, attrs?:string
 * } $args Arguments.
 */
function rc_button( array $args ): void {

	$args = wp_parse_args(
		$args,
		array(
			'label'   => '',
			'url'     => '',
			'variant' => 'primary',
			'arrow'   => true,
			'type'    => 'link',
			'class'   => '',
			'attrs'   => '',
		)
	);

	$classes = trim( 'rc-btn rc-btn--' . $args['variant'] . ' ' . $args['class'] );
	$arrow   = $args['arrow']
		? '<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>'
		: '';

	if ( 'submit' === $args['type'] ) {
		printf(
			'<button type="submit" class="%1$s" %2$s>%3$s%4$s</button>',
			esc_attr( $classes ),
			$args['attrs'], // phpcs:ignore WordPress.Security.EscapeOutput
			esc_html( $args['label'] ),
			$arrow // phpcs:ignore WordPress.Security.EscapeOutput
		);
		return;
	}

	printf(
		'<a href="%1$s" class="%2$s" %3$s>%4$s%5$s</a>',
		esc_url( $args['url'] ),
		esc_attr( $classes ),
		$args['attrs'], // phpcs:ignore WordPress.Security.EscapeOutput
		esc_html( $args['label'] ),
		$arrow // phpcs:ignore WordPress.Security.EscapeOutput
	);
}

/**
 * Render an eyebrow label.
 *
 * @param string $text     Label text.
 * @param bool   $with_rule Show the amber rule.
 */
function rc_eyebrow( string $text, bool $with_rule = true ): void {
	printf(
		'<p class="rc-eyebrow%1$s">%2$s</p>',
		$with_rule ? '' : ' rc-eyebrow--plain',
		esc_html( $text )
	);
}

/**
 * Split a headline into masked lines for the hero reveal.
 *
 * @param string[] $lines Lines of the headline.
 * @return string
 */
function rc_masked_lines( array $lines ): string {
	$out = '<span class="rc-lines">';
	foreach ( array_values( $lines ) as $i => $line ) {
		$out .= sprintf(
			'<span class="rc-line" style="--rc-i:%1$d"><span>%2$s</span></span>',
			(int) $i,
			esc_html( $line )
		);
	}
	return $out . '</span>';
}

/**
 * The primary navigation, used when no menu has been assigned yet.
 *
 * This means a fresh install presents the intended navigation straight
 * away rather than an empty bar, while still deferring to a real menu
 * the moment the client creates one.
 *
 * @return array<int, array{label:string, path:string}>
 */
function rc_nav_items(): array {
	return array(
		array( 'label' => __( 'About', 'rian-cullet' ),          'path' => '/about/' ),
		array( 'label' => __( 'Cullet', 'rian-cullet' ),         'path' => '/glass-cullet/', 'long' => __( 'Glass Cullet', 'rian-cullet' ) ),
		array( 'label' => __( 'Process', 'rian-cullet' ),        'path' => '/process/' ),
		array( 'label' => __( 'Sustainability', 'rian-cullet' ), 'path' => '/sustainability/' ),
		array( 'label' => __( 'Contact', 'rian-cullet' ),        'path' => '/contact/' ),
	);
}

/**
 * Render the fallback navigation list.
 *
 * The header list carries the nav item and link classes; the footer list
 * is plain markup styled by .rc-footer__list, and uses the long labels
 * because it has the room.
 *
 * @param string $class    List class name.
 * @param string $location 'primary' or 'footer'.
 */
function rc_fallback_menu( string $class = 'rc-nav__list', string $location = 'primary' ): void {

	$is_footer = 'footer' === $location;

	echo '<ul class="' . esc_attr( $class ) . '">';

	foreach ( rc_nav_items() as $item ) {
		$url     = home_url( $item['path'] );
		$label   = $is_footer && isset( $item['long'] ) ? $item['long'] : $item['label'];
		$current = trailingslashit( (string) wp_parse_url( (string) home_url( add_query_arg( array() ) ), PHP_URL_PATH ) )
			=== trailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) );

		if ( $is_footer ) {
			printf(
				'<li><a href="%1$s"%2$s>%3$s</a></li>',
				esc_url( $url ),
				$current ? ' aria-current="page"' : '',
				esc_html( $label )
			);
			continue;
		}

		printf(
			'<li class="rc-nav__item"><a class="rc-nav__link%1$s" href="%2$s"%3$s>%4$s</a></li>',
			$current ? ' is-current' : '',
			esc_url( $url ),
			$current ? ' aria-current="page"' : '',
			esc_html( $label )
		);
	}

	echo '</ul>';
}

add_filter( 'nav_menu_css_class', 'rc_primary_menu_item_class', 10, 3 );
/**
 * Give items in a real primary menu the same class as the fallback, so a
 * menu built in wp-admin renders identically to the default navigation.
 *
 * @param string[] $classes Item classes.
 * @param WP_Post  $item    Menu item.
 * @param stdClass $args    wp_nav_menu() arguments.
 * @return string[]
 */
function rc_primary_menu_item_class( $classes, $item, $args ): array {
	$classes = (array) $classes;

	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$classes[] = 'rc-nav__item';
	}

	return $classes;
}

add_filter( 'nav_menu_link_attributes', 'rc_primary_menu_link_attributes', 10, 3 );
/**
 * Style primary menu links as nav links, and mark the current page with
 * the same class the fallback uses. Core already adds aria-current.
 *
 * @param array<string, string> $atts Link attributes.
 * @param WP_Post               $item Menu item.
 * @param stdClass              $args wp_nav_menu() arguments.
 * @return array<string, string>
 */
function rc_primary_menu_link_attributes( $atts, $item, $args ): array {
	$atts = (array) $atts;

	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' rc-nav__link' . ( ! empty( $item->current ) ? ' is-current' : '' ) );
	}

	return $atts;
}

/**
 * Hero slides.
 *
 * Each slide pairs a photograph with a brand line. The order walks the
 * colour story the rest of the page tells: mixed cullet, then green,
 * then amber, then clear.
 *
 * Slide one carries the primary SEO headline and is the only slide
 * loaded eagerly. Every line is real text in the DOM, so all of it is
 * crawlable whether or not the rotation ever runs.
 *
 * The "diamonds" line from the brief is deliberately absent. It is a
 * conversational brand statement, not a headline, and putting it here
 * would read as a gimmick to a procurement manager.
 *
 * @return array<int, array<string, mixed>>
 */
function rc_hero_slides(): array {

	$slides = array(
		array(
			'image' => 'hero-slide-1',
			'alt'   => __( 'Macro photograph of mixed green, amber and clear glass cullet catching natural light.', 'rian-cullet' ),
			'note'  => __( 'Hero 01: mixed cullet, jewel-like, natural light. 2400x1350.', 'rian-cullet' ),
			'lines' => array(
				__( 'Turning waste glass', 'rian-cullet' ),
				__( 'into valuable', 'rian-cullet' ),
				__( 'raw material.', 'rian-cullet' ),
			),
		),
		array(
			'image' => 'hero-slide-2',
			'alt'   => __( 'A deep pile of sorted green glass cullet awaiting processing.', 'rian-cullet' ),
			'note'  => __( 'Hero 02: sorted green cullet pile. 2400x1350.', 'rian-cullet' ),
			'lines' => array(
				__( 'Glass for', 'rian-cullet' ),
				__( 'the next cycle.', 'rian-cullet' ),
			),
		),
		array(
			'image' => 'hero-slide-3',
			'alt'   => __( 'Amber glass cullet fragments lit from behind, showing depth of colour.', 'rian-cullet' ),
			'note'  => __( 'Hero 03: amber cullet, backlit. 2400x1350.', 'rian-cullet' ),
			'lines' => array(
				__( 'Cullets for', 'rian-cullet' ),
				__( 'the next generation.', 'rian-cullet' ),
			),
		),
		array(
			'image' => 'hero-slide-4',
			'alt'   => __( 'Clear and green glass cullet sorted and ready for the furnace.', 'rian-cullet' ),
			'note'  => __( 'Hero 04: clear and green cullet, sorted. 2400x1350.', 'rian-cullet' ),
			'lines' => array(
				__( 'Processed glass.', 'rian-cullet' ),
				__( 'Ready for its next cycle.', 'rian-cullet' ),
			),
		),
	);

	/**
	 * Filters the hero slides.
	 *
	 * @param array<int, array<string, mixed>> $slides Slide definitions.
	 */
	return (array) apply_filters( 'rc_hero_slides', $slides );
}
