<?php
/**
 * Site footer.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_address  = rc_address();
$rc_channels = rc_contact_channels();
?>
</main><!-- #rc-main -->

<footer class="rc-footer rc-surface-ink" data-nav="dark">
	<div class="rc-container rc-container--wide">

		<div class="rc-footer__top">
			<div class="rc-footer__brand">
				<a class="rc-wordmark rc-wordmark--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php rc_logo_mark( 'lazy' ); ?>
					<span class="rc-wordmark__text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				</a>
				<p class="rc-footer__line"><?php esc_html_e( 'Processed glass. Ready for its next cycle.', 'rian-cullet' ); ?></p>
			</div>

			<nav class="rc-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'rian-cullet' ); ?>">
				<h2 class="rc-sr-only"><?php esc_html_e( 'Footer navigation', 'rian-cullet' ); ?></h2>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'rc-footer__list',
							'depth'          => 1,
						)
					);
				} else {
					rc_fallback_menu( 'rc-footer__list', 'footer' );
				}
				?>
			</nav>

			<address class="rc-footer__address">
				<h2 class="rc-sr-only"><?php esc_html_e( 'Registered address', 'rian-cullet' ); ?></h2>
				<span><?php echo esc_html( $rc_address['street'] ); ?></span>
				<span><?php echo esc_html( $rc_address['locality'] . ' &ndash; ' . $rc_address['postcode'] ); ?></span>
				<span><?php echo esc_html( $rc_address['country_name'] ); ?></span>

				<?php if ( ! empty( $rc_channels['email'] ) ) : ?>
					<a class="rc-footer__contact" href="mailto:<?php echo esc_attr( $rc_channels['email'] ); ?>"><?php echo esc_html( $rc_channels['email'] ); ?></a>
				<?php endif; ?>

				<?php if ( ! empty( $rc_channels['phone'] ) ) : ?>
					<a class="rc-footer__contact" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $rc_channels['phone'] ) ); ?>"><?php echo esc_html( $rc_channels['phone'] ); ?></a>
				<?php endif; ?>
			</address>
		</div>

		<hr class="rc-rule rc-footer__rule">

		<div class="rc-footer__bottom">
			<p class="rc-small">
				<?php
				printf(
					/* translators: 1: year, 2: company name */
					esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'rian-cullet' ),
					esc_html( (string) current_time( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
			<p class="rc-small">
				<a class="rc-footer__minor" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'rian-cullet' ); ?></a>
			</p>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
