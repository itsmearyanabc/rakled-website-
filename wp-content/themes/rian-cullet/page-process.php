<?php
/**
 * Process.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part(
	'template-parts/sections/page-hero',
	null,
	array(
		'eyebrow' => __( 'Process', 'rian-cullet' ),
		'title'   => __( 'From discarded glass to industrial resource', 'rian-cullet' ),
		'lede'    => __( 'Collection, sorting, processing and supply. Four stages that turn recovered glass into a material a furnace can accept.', 'rian-cullet' ),
	)
);
?>

<section class="rc-section rc-section--flush-top rc-surface-paper" aria-labelledby="rc-process-intro">
	<div class="rc-container rc-container--wide">
		<div class="rc-split rc-split--5-7">

			<div class="rc-reveal">
				<?php
				rc_figure(
					array(
						'name'   => 'processing-sorting',
						'alt'    => __( 'Recovered glass being sorted by type and colour before processing.', 'rian-cullet' ),
						'ratio'  => 'rc-ratio-editorial',
						'class'  => 'rc-zoom',
						'width'  => 1800,
						'height' => 1200,
						'note'   => __( 'Sorting by type and colour, 3:2 landscape.', 'rian-cullet' ),
					)
				);
				?>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<h2 class="rc-display-3" id="rc-process-intro"><?php esc_html_e( 'Systematic sorting and processing', 'rian-cullet' ); ?></h2>
				<div class="rc-stack" style="margin-top:var(--rc-space-6)">
					<p class="rc-body">
						<?php esc_html_e( 'Recovered glass arrives mixed. What makes it usable again is the discipline applied to it: separation by type and by colour, then preparation to a condition a glass furnace can accept.', 'rian-cullet' ); ?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'Through systematic sorting and processing, we help convert waste glass into a valuable raw material that can be fed into glass furnaces.', 'rian-cullet' ); ?>
					</p>
					<p>
						<a class="rc-link" href="<?php echo esc_url( home_url( '/glass-cullet/' ) ); ?>">
							<?php esc_html_e( 'Cullet types we handle', 'rian-cullet' ); ?>
							<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>
						</a>
					</p>
				</div>
			</div>

		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/sections/process' );
get_template_part( 'template-parts/sections/sustainability' );
get_template_part( 'template-parts/sections/cta' );

get_footer();
