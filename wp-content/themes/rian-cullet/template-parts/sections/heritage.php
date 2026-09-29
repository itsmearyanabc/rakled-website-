<?php
/**
 * Section 09: Heritage.
 *
 * A generational business: the team's combined experience (65+ years)
 * is older than the company itself (1996), so the section leads with the
 * experience and places the founding year inside the story rather than
 * repeating it as the headline.
 *
 * The timeline carries no invented dates or milestones. It marks only
 * what the client states, in order: experience carried across
 * generations, the founding year, companies served, and today's
 * pan-India reach.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_timeline = array(
	array(
		'marker' => __( 'Generations', 'rian-cullet' ),
		'label'  => __( 'Experience in glass cullet, carried from one generation to the next.', 'rian-cullet' ),
	),
	array(
		'marker' => (string) RC_FOUNDED,
		'label'  => __( 'Rian Cullet established in Delhi.', 'rian-cullet' ),
	),
	array(
		'marker' => RC_COMPANIES_SERVED . '+',
		'label'  => __( 'Companies served across the glass manufacturing and recycling ecosystem.', 'rian-cullet' ),
	),
	array(
		'marker' => __( 'Today', 'rian-cullet' ),
		'label'  => sprintf(
			/* translators: %d: number of states */
			__( 'Serving pan-India, across %d+ states.', 'rian-cullet' ),
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
				<span class="rc-mega rc-heritage__year" id="rc-heritage-title" style="margin-top:var(--rc-space-5)"><?php echo esc_html( RC_COMBINED_EXPERIENCE . '+' ); ?><span class="rc-sr-only"> <?php esc_html_e( 'years of combined experience', 'rian-cullet' ); ?></span></span>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<p class="rc-lede rc-heritage__lede">
					<?php esc_html_e( 'Years of combined experience, built across generations.', 'rian-cullet' ); ?>
				</p>
				<p class="rc-body" style="margin-top:var(--rc-space-5)">
					<?php
					printf(
						/* translators: %d: founding year */
						esc_html__( 'Rian Cullet is a generational business. Established in Delhi in %d, it brings that experience to the collection, sorting, processing and recycling of foreign and post-consumer glass cullet, serving customers pan-India.', 'rian-cullet' ),
						(int) RC_FOUNDED
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
