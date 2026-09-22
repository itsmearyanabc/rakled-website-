<?php
/**
 * Section 04: Process.
 *
 * Four stages activate in sequence as the visitor scrolls, with a single
 * hairline filling amber alongside them. Under reduced motion every
 * stage is shown at full strength and the section reads as a list.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_stages = array(
	array(
		'title' => __( 'Collection', 'rian-cullet' ),
		'body'  => __( 'Glass is sourced from relevant industrial and post-consumer streams.', 'rian-cullet' ),
	),
	array(
		'title' => __( 'Sorting', 'rian-cullet' ),
		'body'  => __( 'Material is separated according to relevant characteristics such as type and colour.', 'rian-cullet' ),
	),
	array(
		'title' => __( 'Processing', 'rian-cullet' ),
		'body'  => __( 'Recovered glass is prepared into usable cullet.', 'rian-cullet' ),
	),
	array(
		'title' => __( 'Supply', 'rian-cullet' ),
		'body'  => __( 'Processed cullet is supplied for reuse in glass manufacturing.', 'rian-cullet' ),
	),
);
?>
<section class="rc-section rc-surface-green" data-nav="dark" aria-labelledby="rc-process-title">
	<div class="rc-container rc-container--wide">
		<div class="rc-split rc-split--5-7 rc-split--sticky">

			<div class="rc-split__aside rc-process__head rc-reveal">
				<?php rc_eyebrow( __( 'Process', 'rian-cullet' ) ); ?>

				<h2 class="rc-display-2" id="rc-process-title" style="margin-top:var(--rc-space-5)">
					<?php esc_html_e( 'From discarded glass to industrial resource.', 'rian-cullet' ); ?>
				</h2>

				<p class="rc-body" style="margin-top:var(--rc-space-6)">
					<?php esc_html_e( 'Four stages turn recovered glass into a material a furnace can accept.', 'rian-cullet' ); ?>
				</p>

				<p style="margin-top:var(--rc-space-6)">
					<a class="rc-link" href="<?php echo esc_url( home_url( '/process/' ) ); ?>">
						<?php esc_html_e( 'See the full process', 'rian-cullet' ); ?>
						<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>
					</a>
				</p>
			</div>

			<div class="rc-process__track" data-rc-process>

				<div class="rc-process__rail rc-progress" aria-hidden="true">
					<span class="rc-progress__fill"></span>
				</div>

				<ol style="list-style:none;margin:0;padding:0;display:grid;gap:inherit">
					<?php foreach ( $rc_stages as $rc_i => $rc_stage ) : ?>
						<li class="rc-step rc-reveal">
							<span class="rc-index rc-step__index"><?php echo esc_html( sprintf( '%02d', $rc_i + 1 ) ); ?></span>
							<h3 class="rc-h3 rc-step__title"><?php echo esc_html( $rc_stage['title'] ); ?></h3>
							<p class="rc-step__body"><?php echo esc_html( $rc_stage['body'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>

			</div>

		</div>
	</div>
</section>
