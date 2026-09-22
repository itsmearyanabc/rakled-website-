<?php
/**
 * Starter content.
 *
 * The page templates are resolved by slug, so the theme only takes
 * effect once pages exist at /about/, /glass-cullet/ and so on. Rather
 * than leaving that as a setup instruction nobody reads, this offers a
 * single action in the admin that creates the six pages, sets the front
 * page and builds the navigation menus.
 *
 * It never overwrites: a page that already exists at a slug is adopted,
 * not replaced, so running it twice is safe.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

const RC_SETUP_ACTION = 'rc_install_starter_content';

/**
 * The pages this theme expects, in navigation order.
 *
 * @return array<string, string> Slug => title.
 */
function rc_required_pages(): array {
	return array(
		'home'           => __( 'Home', 'rian-cullet' ),
		'about'          => __( 'About', 'rian-cullet' ),
		'glass-cullet'   => __( 'Glass Cullet', 'rian-cullet' ),
		'process'        => __( 'Process', 'rian-cullet' ),
		'sustainability' => __( 'Sustainability', 'rian-cullet' ),
		'contact'        => __( 'Contact', 'rian-cullet' ),
		'privacy-policy' => __( 'Privacy Policy', 'rian-cullet' ),
	);
}

/**
 * Slugs that are still missing.
 *
 * @return string[]
 */
function rc_missing_pages(): array {
	$missing = array();

	foreach ( rc_required_pages() as $slug => $title ) {
		if ( ! get_page_by_path( $slug ) ) {
			$missing[] = $slug;
		}
	}

	return $missing;
}

add_action( 'admin_notices', 'rc_setup_notice' );
/**
 * Prompt to install starter content while anything is missing.
 */
function rc_setup_notice(): void {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$missing = rc_missing_pages();

	if ( ! $missing ) {
		return;
	}

	$url = wp_nonce_url(
		admin_url( 'admin-post.php?action=' . RC_SETUP_ACTION ),
		RC_SETUP_ACTION,
		'rc_setup_nonce'
	);
	?>
	<div class="notice notice-info">
		<p>
			<strong><?php esc_html_e( 'Rian Cullet', 'rian-cullet' ); ?></strong> &mdash;
			<?php
			printf(
				/* translators: %d: number of pages */
				esc_html__( '%d page(s) this theme expects do not exist yet. Existing pages are never overwritten.', 'rian-cullet' ),
				count( $missing )
			);
			?>
		</p>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( $url ); ?>">
				<?php esc_html_e( 'Create pages and menus', 'rian-cullet' ); ?>
			</a>
		</p>
	</div>
	<?php
}

add_action( 'admin_post_' . RC_SETUP_ACTION, 'rc_install_starter_content' );
/**
 * Admin action: check permission, then create the starter content.
 */
function rc_install_starter_content(): void {

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'rian-cullet' ) );
	}

	check_admin_referer( RC_SETUP_ACTION, 'rc_setup_nonce' );

	rc_create_starter_content();

	wp_safe_redirect( add_query_arg( 'rc_setup', 'done', admin_url( 'edit.php?post_type=page' ) ) );
	exit;
}

/**
 * Create the pages, set the front page and build the menus.
 *
 * Kept free of permission checks and redirects so that provisioning
 * scripts (WP-CLI, the Playground blueprint in tools/) can call it
 * directly. Callers from a request must check capability first.
 *
 * @return array<string, int> Slug => page ID.
 */
function rc_create_starter_content(): array {

	$ids = array();

	foreach ( rc_required_pages() as $slug => $title ) {
		$existing = get_page_by_path( $slug );

		if ( $existing ) {
			$ids[ $slug ] = (int) $existing->ID;

			/*
			 * Every WordPress install creates the privacy policy as an
			 * unpublished draft of "Suggested text" boilerplate, so the
			 * footer link 404s. If that draft is untouched (never saved
			 * since creation), publish it empty: the template then shows
			 * its "not published yet" notice and seo.php keeps it noindex.
			 * A draft anyone has edited is left exactly as it is.
			 */
			if (
				'privacy-policy' === $slug
				&& 'publish' !== $existing->post_status
				&& $existing->post_modified === $existing->post_date
			) {
				wp_update_post(
					array(
						'ID'           => $existing->ID,
						'post_status'  => 'publish',
						'post_content' => '',
					)
				);
			}

			continue;
		}

		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_content' => '',
			)
		);

		if ( ! is_wp_error( $id ) ) {
			$ids[ $slug ] = (int) $id;
		}
	}

	if ( isset( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	if ( isset( $ids['privacy-policy'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $ids['privacy-policy'] );
	}

	$slugs = array( 'about', 'glass-cullet', 'process', 'sustainability', 'contact' );

	// The header bar is tight, so it carries the short label; the footer
	// has room for the page's full title. Both match the design preview.
	rc_build_menu( 'primary', __( 'Primary', 'rian-cullet' ), $ids, $slugs, array( 'glass-cullet' => __( 'Cullet', 'rian-cullet' ) ) );
	rc_build_menu( 'footer', __( 'Footer', 'rian-cullet' ), $ids, $slugs );

	return $ids;
}

/**
 * Create a menu at a location if that location has none.
 *
 * @param string               $location Theme location.
 * @param string               $name     Menu name.
 * @param array<string,int>    $ids      Slug => page ID.
 * @param string[]             $slugs    Slugs to include, in order.
 * @param array<string,string> $labels   Slug => menu label, where it should differ from the page title.
 */
function rc_build_menu( string $location, string $name, array $ids, array $slugs, array $labels = array() ): void {

	if ( has_nav_menu( $location ) ) {
		return;
	}

	$menu = wp_get_nav_menu_object( $name );
	$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );

	if ( ! $menu_id || is_wp_error( $menu_id ) ) {
		return;
	}

	// Only populate a menu we just created and that is still empty.
	if ( ! wp_get_nav_menu_items( $menu_id ) ) {
		foreach ( $slugs as $slug ) {
			if ( ! isset( $ids[ $slug ] ) ) {
				continue;
			}

			$item = array(
				'menu-item-object-id' => $ids[ $slug ],
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			);

			if ( isset( $labels[ $slug ] ) ) {
				$item['menu-item-title'] = $labels[ $slug ];
			}

			wp_update_nav_menu_item( $menu_id, 0, $item );
		}
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
