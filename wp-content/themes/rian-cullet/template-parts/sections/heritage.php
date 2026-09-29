<?php
/**
 * Section 09: Heritage.
 *
 * The timeline deliberately carries no invented dates or milestones.
 * It marks only what the client states: the founding year, combined
 * experience, companies served, and today's pan-India reach.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_timeline = array(
	array(
		'marker' => (string) RC_FOUNDED,
		'label'  => __( 'Company established in Delhi.', 'rian-cullet' ),
	),
	array(
		'marker' => RC_COMBINED_EXPERIENCE . '+',
		'label'  => __( 'Years of combined experience in collection, sorting and processing.', 'rian-cullet' ),
	),
	array(
		'marker' => RC_COMPANIES_SERVED . '+',
		'label'  => __( 'Companies served across the glass manufacturing and recycling ecosystem.', 'rian-cullet' ),
	),
	array(
		'marker' => __( 'Today', 'rian-cullet' ),
		'label'  => sprintf(
			/* translators: %d: number of states */
			__( 'Pan-India supply, with customers in %d+ states.', 'rian-cullet' ),
			RC_STATES_SERVED
		),
	),
);
?>
<section class="rc-section rc-surface-ink" data-nav="dark" aria-labelledby="rc-heritage-title">
	<div class="rc-container rc-container--wide">

		<div class="rc-split rc-split--6-6">
			<div class="rc-reveal">
				<?php rc_eyebrow( __( 'Heritage', 'rian-cullet' ) ); ?>
				<span class="rc-mega rc-heritage__year" id="rc-heritage-title" style="margin-top:var(--rc-space-5)"><?php echo esc_html( (string) RC_FOUNDED ); ?></span>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<p class="rc-lede rc-heritage__lede">
					<?php esc_html_e( 'The beginning of the Rian Cullet journey.', 'rian-cullet' ); ?>
				</p>
				<p class="rc-body" style="margin-top:var(--rc-space-5)">
					<?php
					printf(
						/* translators: 1: founding year, 2: years of combined experience */
						esc_html__( 'Based in Delhi and operating in glass cullet since %1$d, the company brings %2$d+ years of combined experience to the collection, sorting, processing and recycling of foreign and post-consumer glass cullet.', 'rian-cullet' ),
						(int) RC_FOUNDED,
						(int) RC_COMBINED_EXPERIENCE
					);
					?>
				</p>
			</div>
		</div>

		<ol class="rc-timeline">
			<?php foreach ( $rc_timeline as $rc_i => $rc_point ) : ?>
				<li class="rc-timeline__item rc-reveal" style="--rc-i:<?php echo (int) $rc_i; ?>">
					<span class="rc-index rc-timeline__marker"><?php echo esc_html( $rc_point['marker'] ); ?></span>
					<p class="rc-timeline__label"><?php echo esc_html( $rc_point['label'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>
