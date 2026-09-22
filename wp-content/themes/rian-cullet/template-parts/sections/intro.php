<?php
/**
 * Section 03: Introduction.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;
?>
<section class="rc-section rc-surface-paper" aria-labelledby="rc-intro-title">
	<div class="rc-container rc-container--wide">
		<div class="rc-split rc-split--7-5">

			<div class="rc-reveal">
				<?php rc_eyebrow( __( 'Introduction', 'rian-cullet' ) ); ?>

				<h2 class="rc-display-2 rc-intro__statement" id="rc-intro-title" style="margin-top:var(--rc-space-5)">
					<?php esc_html_e( 'Glass does not have to end its journey as waste.', 'rian-cullet' ); ?>
				</h2>

				<div class="rc-intro__body rc-stack">
					<p class="rc-body">
						<?php esc_html_e( 'Rian Cullet collects, sorts and processes glass that has already served its first purpose. Sorted by type and colour and prepared to a consistent standard, it returns to the furnace as raw material rather than being treated as waste.', 'rian-cullet' ); ?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'That work keeps recoverable glass out of landfill and gives glass manufacturers a dependable source of recycled material.', 'rian-cullet' ); ?>
					</p>
					<p>
						<a class="rc-link" href="<?php echo esc_url( home_url( '/glass-cullet/' ) ); ?>">
							<?php esc_html_e( 'What is glass cullet', 'rian-cullet' ); ?>
							<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>
						</a>
					</p>
				</div>
			</div>

			<div class="rc-intro__media rc-reveal" style="--rc-i:1">
				<?php
				rc_figure(
					array(
						'name'   => 'intro-cullet-macro',
						'alt'    => __( 'Close-up of sorted glass cullet fragments showing colour and texture.', 'rian-cullet' ),
						'ratio'  => 'rc-ratio-portrait',
						'class'  => 'rc-zoom',
						'width'  => 1200,
						'height' => 1500,
						'note'   => __( 'Editorial: sorted cullet close-up, 4:5 portrait. 1200x1500.', 'rian-cullet' ),
					)
				);
				?>
			</div>

		</div>
	</div>
</section>
