<?php
/**
 * Section 02: Trust and heritage figures.
 *
 * Only the three figures supplied in the brief appear here. The years
 * figure is derived from the founding year rather than hard-coded.
 *
 * The final values are printed by PHP, so the correct numbers are in the
 * HTML for search engines, for visitors without JavaScript and for
 * anyone using reduced motion. counters.js only animates what is there.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_years = rc_years_of_experience();

$rc_figures = array(
	array(
		'value'  => (string) RC_FOUNDED,
		'count'  => null,
		'label'  => __( 'Established', 'rian-cullet' ),
	),
	array(
		'value'  => $rc_years . '+',
		'count'  => $rc_years,
		'suffix' => '+',
		'label'  => __( 'Years of experience', 'rian-cullet' ),
	),
	array(
		'value'  => '35+',
		'count'  => 35,
		'suffix' => '+',
		'label'  => __( 'Companies served', 'rian-cullet' ),
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
