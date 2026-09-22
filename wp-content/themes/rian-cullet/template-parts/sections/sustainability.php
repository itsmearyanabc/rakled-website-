<?php
/**
 * Section 10: Sustainability.
 *
 * The flow is descriptive, not quantified. No tonnages, percentages or
 * emissions savings appear anywhere in this section.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_flow = array(
	array( 'label' => __( 'Waste glass', 'rian-cullet' ),   'note' => __( 'Glass that has served its first purpose.', 'rian-cullet' ) ),
	array( 'label' => __( 'Recovery', 'rian-cullet' ),      'note' => __( 'Collected from relevant streams.', 'rian-cullet' ) ),
	array( 'label' => __( 'Sorting', 'rian-cullet' ),       'note' => __( 'Separated by type and colour.', 'rian-cullet' ) ),
	array( 'label' => __( 'Processing', 'rian-cullet' ),    'note' => __( 'Prepared into usable cullet.', 'rian-cullet' ) ),
	array( 'label' => __( 'Cullet', 'rian-cullet' ),        'note' => __( 'Ready for the furnace.', 'rian-cullet' ) ),
	array( 'label' => __( 'New glass', 'rian-cullet' ),     'note' => __( 'Returned to manufacturing.', 'rian-cullet' ) ),
);
?>
<section class="rc-section rc-surface-paper" aria-labelledby="rc-sustainability-title">
	<div class="rc-container rc-container--wide">

		<div class="rc-section-head rc-reveal">
			<?php rc_eyebrow( __( 'Sustainability', 'rian-cullet' ) ); ?>
			<h2 class="rc-display-2" id="rc-sustainability-title"><?php esc_html_e( 'Building a more circular glass industry', 'rian-cullet' ); ?></h2>
			<p class="rc-lede"><?php esc_html_e( 'Glass that is recovered, sorted and processed can re-enter manufacturing as raw material. The cycle closes rather than ending at landfill.', 'rian-cullet' ); ?></p>
		</div>

		<ol class="rc-flow" data-rc-process>
			<?php foreach ( $rc_flow as $rc_i => $rc_node ) : ?>
				<li class="rc-flow__node rc-step rc-reveal" style="--rc-i:<?php echo (int) $rc_i; ?>">
					<span class="rc-flow__label"><?php echo esc_html( $rc_node['label'] ); ?></span>
					<span class="rc-flow__note"><?php echo esc_html( $rc_node['note'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ol>

		<p style="margin-top:var(--rc-space-8)">
			<a class="rc-link" href="<?php echo esc_url( home_url( '/sustainability/' ) ); ?>">
				<?php esc_html_e( 'Our approach to sustainability', 'rian-cullet' ); ?>
				<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>
			</a>
		</p>

	</div>
</section>
