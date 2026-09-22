<?php
/**
 * Section 11: B2B call to action.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;
?>
<section class="rc-section rc-surface-green" data-nav="dark" aria-labelledby="rc-cta-title">
	<div class="rc-container rc-container--wide">
		<div class="rc-cta__inner rc-reveal">

			<?php rc_eyebrow( __( 'Enquiries', 'rian-cullet' ) ); ?>

			<h2 class="rc-display-2" id="rc-cta-title" style="margin-top:var(--rc-space-5)">
				<?php esc_html_e( 'Looking for a reliable glass cullet source?', 'rian-cullet' ); ?>
			</h2>

			<p class="rc-lede" style="margin-top:var(--rc-space-5)">
				<?php esc_html_e( 'Connect with our team to discuss your material requirements.', 'rian-cullet' ); ?>
			</p>

			<div class="rc-cta__actions">
				<?php
				rc_button(
					array(
						'label' => __( 'Send an enquiry', 'rian-cullet' ),
						'url'   => home_url( '/contact/#rc-enquiry' ),
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
	</div>
</section>
