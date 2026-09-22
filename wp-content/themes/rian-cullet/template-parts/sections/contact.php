<?php
/**
 * Section 12: Contact.
 *
 * Phone and email are printed only when the client has supplied them.
 * Neither is invented here, and neither appears as a dummy placeholder.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_address  = rc_address();
$rc_channels = rc_contact_channels();
?>
<section class="rc-section rc-surface-paper" id="rc-enquiry" aria-labelledby="rc-contact-title">
	<div class="rc-container rc-container--wide">
		<div class="rc-split rc-split--4-8">

			<div class="rc-reveal">
				<?php rc_eyebrow( __( 'Contact', 'rian-cullet' ) ); ?>

				<h2 class="rc-display-3" id="rc-contact-title" style="margin-top:var(--rc-space-5)">
					<?php esc_html_e( 'Discuss material requirements', 'rian-cullet' ); ?>
				</h2>

				<div class="rc-contact__group" style="margin-top:var(--rc-space-7)">
					<p class="rc-eyebrow rc-eyebrow--plain" style="color:var(--rc-ink-muted)"><?php esc_html_e( 'Registered address', 'rian-cullet' ); ?></p>
					<address class="rc-contact__details rc-body" style="margin-top:var(--rc-space-4)">
						<span><strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong></span>
						<span><?php echo esc_html( $rc_address['street'] ); ?></span>
						<span><?php echo esc_html( $rc_address['locality'] . ' – ' . $rc_address['postcode'] ); ?></span>
						<span><?php echo esc_html( $rc_address['country_name'] ); ?></span>
					</address>
				</div>

				<?php if ( ! empty( $rc_channels['email'] ) || ! empty( $rc_channels['phone'] ) ) : ?>
					<div class="rc-contact__group">
						<p class="rc-eyebrow rc-eyebrow--plain" style="color:var(--rc-ink-muted)"><?php esc_html_e( 'Direct', 'rian-cullet' ); ?></p>
						<?php if ( ! empty( $rc_channels['email'] ) ) : ?>
							<p style="margin-top:var(--rc-space-4)"><a class="rc-link" href="mailto:<?php echo esc_attr( $rc_channels['email'] ); ?>"><?php echo esc_html( $rc_channels['email'] ); ?></a></p>
						<?php endif; ?>
						<?php if ( ! empty( $rc_channels['phone'] ) ) : ?>
							<p style="margin-top:var(--rc-space-4)"><a class="rc-link" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $rc_channels['phone'] ) ); ?>"><?php echo esc_html( $rc_channels['phone'] ); ?></a></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<?php rc_enquiry_form(); ?>
			</div>

		</div>
	</div>
</section>
