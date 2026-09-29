<?php
/**
 * About.
 *
 * All copy on this page is the client's own wording, used verbatim.
 * Nothing about qualifications, awards, capacity or history is added.
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
		'eyebrow' => __( 'About', 'rian-cullet' ),
		/* translators: %d: founding year */
		'title'   => sprintf( __( 'Glass cullet from Delhi, since %d.', 'rian-cullet' ), RC_FOUNDED ),
		'lede'    => __( 'Collection, sorting, processing and recycling of foreign and post-consumer glass cullet for reuse in glass manufacturing.', 'rian-cullet' ),
	)
);
?>

<section class="rc-section rc-section--flush-top rc-surface-paper" aria-labelledby="rc-about-company">
	<div class="rc-container rc-container--wide">
		<div class="rc-split rc-split--7-5">

			<div class="rc-reveal">
				<h2 class="rc-display-3" id="rc-about-company"><?php esc_html_e( 'About Rian Cullet', 'rian-cullet' ); ?></h2>

				<div class="rc-stack" style="margin-top:var(--rc-space-6)">
					<p class="rc-body">
						<?php
						printf(
							/* translators: 1: founding year, 2: years of combined experience */
							esc_html__( 'Rian Cullet is a generational business based in Delhi. Established in %1$d, it brings %2$d+ years of combined experience in glass cullet, built across generations.', 'rian-cullet' ),
							(int) RC_FOUNDED,
							(int) RC_COMBINED_EXPERIENCE
						);
						?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'We specialise in the collection, sorting, processing and recycling of foreign and post-consumer glass cullets, making them suitable for reuse in glass manufacturing. Through systematic sorting and processing, we help convert waste glass into a valuable raw material that can be fed into glass furnaces.', 'rian-cullet' ); ?>
					</p>
					<p class="rc-body">
						<?php
						printf(
							/* translators: 1: companies served, 2: states served */
							esc_html__( 'Over the years, Rian Cullet has served %1$d+ companies across %2$d+ states, pan-India, building trust within the glass manufacturing and recycling ecosystem.', 'rian-cullet' ),
							(int) RC_COMPANIES_SERVED,
							(int) RC_STATES_SERVED
						);
						?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'Our work also contributes to reducing the amount of glass waste going to landfills, while creating an economically valuable source of recycled material.', 'rian-cullet' ); ?>
					</p>
					<p>
						<a class="rc-link" href="<?php echo esc_url( home_url( '/glass-cullet/' ) ); ?>">
							<?php esc_html_e( 'Our glass cullet', 'rian-cullet' ); ?>
							<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>
						</a>
					</p>
				</div>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<?php
				rc_figure(
					array(
						'name'   => 'processing-sorting',
						'alt'    => __( 'Recovered glass being sorted and graded before processing.', 'rian-cullet' ),
						'ratio'  => 'rc-ratio-portrait',
						'class'  => 'rc-zoom',
						'width'  => 1200,
						'height' => 1500,
						'note'   => __( 'Sorting and grading recovered glass, 4:5 portrait.', 'rian-cullet' ),
					)
				);
				?>
			</div>

		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/sections/stats' );
get_template_part( 'template-parts/sections/founder' );
get_template_part( 'template-parts/sections/heritage' );
get_template_part( 'template-parts/sections/cta' );

get_footer();
