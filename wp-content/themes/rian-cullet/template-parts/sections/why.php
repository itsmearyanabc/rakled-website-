<?php
/**
 * Section 07: Why recycled glass matters.
 *
 * Deliberately free of numerical claims. No percentages, tonnages or
 * emissions figures appear here because none were supplied, and an
 * invented one would be the fastest way to lose a procurement manager.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_reasons = array(
	array(
		'title' => __( 'Lower melting requirements', 'rian-cullet' ),
		'body'  => __( 'Cullet can help reduce the melting temperature required in glass manufacturing.', 'rian-cullet' ),
	),
	array(
		'title' => __( 'Energy efficiency', 'rian-cullet' ),
		'body'  => __( 'Using recycled glass as a raw material can contribute to lower energy requirements, and to the emissions associated with them.', 'rian-cullet' ),
	),
	array(
		'title' => __( 'Circular manufacturing', 'rian-cullet' ),
		'body'  => __( 'Recovered glass can be returned to the manufacturing cycle rather than being treated solely as waste.', 'rian-cullet' ),
	),
);
?>
<section class="rc-section rc-surface-paper" aria-labelledby="rc-why-title">
	<div class="rc-container rc-container--wide">

		<div class="rc-section-head rc-reveal">
			<?php rc_eyebrow( __( 'Why cullet matters', 'rian-cullet' ) ); ?>
			<h2 class="rc-display-2" id="rc-why-title"><?php esc_html_e( 'Why recycled glass matters', 'rian-cullet' ); ?></h2>
		</div>

		<div class="rc-why__cols rc-cols rc-cols--3 rc-ruled-cols">
			<?php foreach ( $rc_reasons as $rc_i => $rc_reason ) : ?>
				<div class="rc-reveal" style="--rc-i:<?php echo (int) $rc_i; ?>">
					<span class="rc-index"><?php echo esc_html( sprintf( '%02d', $rc_i + 1 ) ); ?></span>
					<h3 class="rc-h3 rc-why__title"><?php echo esc_html( $rc_reason['title'] ); ?></h3>
					<p class="rc-body"><?php echo esc_html( $rc_reason['body'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="rc-mega rc-why__statement rc-reveal">
			<?php esc_html_e( 'Waste becomes input.', 'rian-cullet' ); ?>
		</p>

	</div>
</section>
