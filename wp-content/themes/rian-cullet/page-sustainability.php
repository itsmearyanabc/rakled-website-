<?php
/**
 * Sustainability.
 *
 * Deliberately free of figures. No percentages, tonnages, emissions
 * savings or landfill statistics appear anywhere on this page, because
 * none were supplied. Every statement here is directional, which is
 * both accurate and more credible to a sustainability professional than
 * an unsourced number would be.
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
		'eyebrow' => __( 'Sustainability', 'rian-cullet' ),
		'title'   => __( 'Building a more circular glass industry', 'rian-cullet' ),
		'lede'    => __( 'Glass recovered, sorted and processed can re-enter manufacturing as raw material rather than ending at landfill.', 'rian-cullet' ),
	)
);
?>

<section class="rc-section rc-section--flush-top rc-surface-paper" aria-labelledby="rc-sustainability-objective">
	<div class="rc-container rc-container--wide">
		<div class="rc-split rc-split--7-5">

			<div class="rc-reveal">
				<h2 class="rc-display-3" id="rc-sustainability-objective"><?php esc_html_e( 'Our objective', 'rian-cullet' ); ?></h2>
				<div class="rc-stack" style="margin-top:var(--rc-space-6)">
					<p class="rc-body">
						<?php esc_html_e( 'At Rian Cullet, our objective is to ensure that waste glass is properly sorted, processed, recycled and returned to the manufacturing cycle, helping create a more sustainable and circular glass industry.', 'rian-cullet' ); ?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'Our work also contributes to reducing the amount of glass waste going to landfills, while creating an economically valuable source of recycled material.', 'rian-cullet' ); ?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'Glass is well suited to this. It can be recovered, sorted by colour and returned to the furnace as an input rather than treated solely as waste.', 'rian-cullet' ); ?>
					</p>
				</div>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<?php
				rc_figure(
					array(
						'name'   => 'green-glass',
						'alt'    => __( 'Sorted green glass cullet ready to return to the manufacturing cycle.', 'rian-cullet' ),
						'ratio'  => 'rc-ratio-portrait',
						'class'  => 'rc-zoom',
						'width'  => 1200,
						'height' => 1500,
						'note'   => __( 'Sorted green cullet, 4:5 portrait.', 'rian-cullet' ),
					)
				);
				?>
			</div>

		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/sections/why' );
get_template_part( 'template-parts/sections/sustainability' );
get_template_part( 'template-parts/sections/cta' );

get_footer();
