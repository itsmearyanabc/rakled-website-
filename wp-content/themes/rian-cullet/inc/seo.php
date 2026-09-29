<?php
/**
 * SEO output: meta description, canonical, Open Graph, robots.
 *
 * The theme stands down entirely if Yoast or Rank Math is active, so a
 * later plugin install cannot produce two competing sets of tags.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

/**
 * Whether a dedicated SEO plugin is handling metadata.
 *
 * @return bool
 */
function rc_seo_plugin_active(): bool {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'All_in_One_SEO_Pack' );
}

/**
 * Default meta descriptions, keyed by page slug.
 *
 * One primary intent per page keeps the six pages from competing with
 * each other for the same query.
 *
 * @return array<string, string>
 */
function rc_meta_descriptions(): array {
	return array(
		/* translators: %d: founding year */
		'_front'         => sprintf( __( 'Rian Cullet is a Delhi-based glass cullet company established in %d, collecting, sorting, processing and supplying recycled glass cullet pan-India.', 'rian-cullet' ), RC_FOUNDED ),
		/* translators: %d: founding year */
		'about'          => sprintf( __( 'Established in Delhi in %d and founded by Ms. Indu Bhatia, Rian Cullet collects, sorts and processes glass cullet for reuse in glass manufacturing.', 'rian-cullet' ), RC_FOUNDED ),
		'glass-cullet'   => __( 'What glass cullet is: factory cullet, foreign post-consumer cullet and flint (white) cullet, and how container and flat glass are sorted by colour for reuse.', 'rian-cullet' ),
		'process'        => __( 'How Rian Cullet turns recovered glass into usable cullet: collection, sorting by type and colour, processing, and supply to glass manufacturers.', 'rian-cullet' ),
		'sustainability' => __( 'Recovered glass returned to the manufacturing cycle. How recycled cullet supports lower melting requirements and a more circular glass industry.', 'rian-cullet' ),
		'contact'        => __( 'Contact Rian Cullet in Delhi to discuss glass cullet requirements. Enquire about factory, foreign or flint cullet, supplied pan-India.', 'rian-cullet' ),
	);
}

/**
 * Resolve the meta description for the current view.
 *
 * @return string
 */
function rc_meta_description(): string {

	$map = rc_meta_descriptions();

	if ( is_front_page() ) {
		$description = $map['_front'];
	} elseif ( is_page() ) {
		$slug        = (string) get_post_field( 'post_name', get_queried_object_id() );
		$description = $map[ $slug ] ?? '';

		if ( '' === $description ) {
			$description = (string) get_the_excerpt();
		}
	} else {
		$description = get_bloginfo( 'description' );
	}

	/**
	 * Filters the meta description.
	 *
	 * @param string $description Description text.
	 */
	$description = (string) apply_filters( 'rc_meta_description', $description );

	return trim( wp_strip_all_tags( $description ) );
}

add_filter( 'document_title_separator', 'rc_title_separator' );
/**
 * Use a pipe between page and site name: "About | Rian Cullet".
 *
 * @param string $separator Default separator.
 * @return string
 */
function rc_title_separator( string $separator ): string {
	return rc_seo_plugin_active() ? $separator : '|';
}

add_filter( 'document_title_parts', 'rc_title_parts' );
/**
 * Lead the homepage title with the primary search intent rather than
 * the bare company name, which is all WordPress gives it by default.
 *
 * @param array<string, string> $parts Title parts.
 * @return array<string, string>
 */
function rc_title_parts( array $parts ): array {

	if ( rc_seo_plugin_active() || ! is_front_page() ) {
		return $parts;
	}

	return array(
		'title' => __( 'Glass Cullet Supplier & Recycling Company in Delhi', 'rian-cullet' ),
		'site'  => get_bloginfo( 'name' ),
	);
}

add_action( 'wp_head', 'rc_output_meta', 2 );
/**
 * Print description, canonical, robots and Open Graph tags.
 */
function rc_output_meta(): void {

	if ( rc_seo_plugin_active() ) {
		return;
	}

	$description = rc_meta_description();
	$canonical   = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );
	$title       = wp_get_document_title();

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}

	if ( $canonical ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	}

	// The privacy policy has no content yet, so keep it out of the index
	// until the client supplies the real text.
	if ( is_page( 'privacy-policy' ) && ! get_the_content() ) {
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	}

	printf( '<meta property="og:type" content="%s">' . "\n", is_front_page() ? 'website' : 'article' );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( get_locale() ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );

	if ( $description ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}

	if ( $canonical ) {
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
	}

	$og_image = rc_og_image();

	if ( $og_image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $og_image ) );
		echo '<meta property="og:image:width" content="1200">' . "\n";
		echo '<meta property="og:image:height" content="630">' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	} else {
		echo '<meta name="twitter:card" content="summary">' . "\n";
	}

	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );

	if ( $description ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $description ) );
	}
}

/**
 * The sharing image: the page thumbnail, else the theme default.
 *
 * Returns an empty string rather than a broken URL when neither exists,
 * so no tag is printed at all.
 *
 * @return string
 */
function rc_og_image(): string {

	if ( is_singular() && has_post_thumbnail() ) {
		$thumb = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
		if ( $thumb ) {
			return (string) $thumb;
		}
	}

	$default = rc_image_sources( 'og-default' );

	return $default ? (string) reset( $default ) : '';
}
