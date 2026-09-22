<?php
/**
 * 404.
 *
 * A dead end is still a chance to route a buyer somewhere useful, so
 * this offers the material and contact pages rather than a search box.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="rc-section rc-surface-paper" style="padding-top:calc(var(--rc-header-h) + var(--rc-space-10))">
	<div class="rc-container rc-container--wide">
		<div class="rc-section-head">
			<?php rc_eyebrow( __( 'Error 404', 'rian-cullet' ) ); ?>
			<h1 class="rc-display-2"><?php esc_html_e( 'This page is no longer in the cycle.', 'rian-cullet' ); ?></h1>
			<p class="rc-lede"><?php esc_html_e( 'The page you were looking for could not be found. These may be what you need.', 'rian-cullet' ); ?></p>
		</div>

		<div class="rc-hero__actions" style="margin-top:var(--rc-space-8)">
			<?php
			rc_button(
				array(
					'label' => __( 'Explore our cullet', 'rian-cullet' ),
					'url'   => home_url( '/glass-cullet/' ),
				)
			);
			rc_button(
				array(
					'label'   => __( 'Contact us', 'rian-cullet' ),
					'url'     => home_url( '/contact/' ),
					'variant' => 'secondary',
					'arrow'   => false,
				)
			);
			?>
		</div>
	</div>
</section>
<?php
get_footer();
