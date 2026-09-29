<?php
/**
 * Section 02: Trust and heritage figures.
 *
 * Only figures the client supplied appear here, read from the constants
 * in functions.php. "Combined experience" is the team's, which is why it
 * exceeds the company's own age.
 *
 * The final values are printed by PHP, so the correct numbers are in the
 * HTML for search engines, for visitors without JavaScript and for
 * anyone using reduced motion. counters.js only animates what is there.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_figures = array(
	array(
		'value'  => (string) RC_FOUNDED,
		'count'  => null,
		'label'  => __( 'Established', 'rian-cullet' ),
	),
	array(
		'value'  => RC_COMBINED_EXPERIENCE . '+',
		'count'  => RC_COMBINED_EXPERIENCE,
		'suffix' => '+',
		'label'  => __( 'Years of combined experience', 'rian-cullet' ),
	),
	array(
		'value'  => RC_COMPANIES_SERVED . '+',
		'count'  => RC_COMPANIES_SERVED,
		'suffix' => '+',
		'label'  => __( 'Companies served', 'rian-cullet' ),
	),
	array(
		'value'  => RC_STATES_SERVED . '+',
		'count'  => RC_STATES_SERVED,
		'suffix' => '+',
		'label'  => __( 'States served, pan-India', 'rian-cullet' ),
	),
);
?>
<section class="rc-section rc-section--tight rc-surface-paper" aria-label="<?php esc_attr_e( 'Company at a glance', 'rian-cullet' ); ?>">
	<div class="rc-container rc-container--wide">
		<div class="rc-stats">
			<?php foreach ( $rc_figures as $rc_i => $rc_figure ) : ?>
				<div class="rc-stat rc-reveal" style="--rc-i:<?php echo (int) $rc_i; ?>">
					<span class="rc-stat__value rc-counter"
						<?php if ( ! empty( $rc_figure['count'] ) ) : ?>
							data-rc-count="<?php echo (int) $rc_figure['count']; ?>"
							data-rc-suffix="<?php echo esc_attr( $rc_figure['suffix'] ?? '' ); ?>"
						<?php endif; ?>
					><?php echo esc_html( $rc_figure['value'] ); ?></span>
					<span class="rc-stat__label"><?php echo esc_html( $rc_figure['label'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
