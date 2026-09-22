<?php
/**
 * Contact.
 *
 * The enquiry form is the page. A map embed is omitted deliberately:
 * a third-party iframe costs several hundred kilobytes and sets
 * tracking cookies before the visitor has agreed to anything, which is
 * a poor trade for a B2B supplier whose buyers arrive by email.
 * A plain link opens the location in the visitor's own map app instead.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

get_header();

$rc_address = rc_address();

$rc_maps_query = rawurlencode(
	$rc_address['street'] . ', ' . $rc_address['locality'] . ' ' . $rc_address['postcode'] . ', ' . $rc_address['country_name']
);

get_template_part(
	'template-parts/sections/page-hero',
	null,
	array(
		'eyebrow' => __( 'Contact', 'rian-cullet' ),
		'title'   => __( 'Discuss material requirements', 'rian-cullet' ),
		'lede'    => __( 'Tell us what you need and our team will come back to you. Enquiries from glass manufacturers, procurement teams and recycling partners are all welcome.', 'rian-cullet' ),
	)
);

get_template_part( 'template-parts/sections/contact' );
?>

<section class="rc-section rc-section--tight rc-surface-paper" aria-labelledby="rc-location">
	<div class="rc-container rc-container--wide">
		<hr class="rc-rule">
		<div class="rc-split rc-split--4-8" style="margin-top:var(--rc-space-7)">

			<div class="rc-reveal">
				<h2 class="rc-h3" id="rc-location"><?php esc_html_e( 'Location', 'rian-cullet' ); ?></h2>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<p class="rc-body">
					<?php esc_html_e( 'Our registered address is in Tikri Kalan, in the north-west of Delhi.', 'rian-cullet' ); ?>
				</p>
				<p style="margin-top:var(--rc-space-5)">
					<a
						class="rc-link"
						href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo esc_attr( $rc_maps_query ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<?php esc_html_e( 'Open in maps', 'rian-cullet' ); ?>
						<span class="rc-sr-only"><?php esc_html_e( '(opens in a new tab)', 'rian-cullet' ); ?></span>
						<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>
					</a>
				</p>
			</div>

		</div>
	</div>
</section>

<?php
get_footer();
