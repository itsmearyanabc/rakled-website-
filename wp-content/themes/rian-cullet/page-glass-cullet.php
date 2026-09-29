<?php
/**
 * Glass Cullet.
 *
 * The SEO pillar. Home, Process and Sustainability all link into this
 * page, and it is the only page that defines the material in full.
 *
 * Container glass and flat glass are described in standard industry
 * terms. No grade, specification, tonnage or purity claim appears here,
 * because none was supplied.
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
		'eyebrow' => __( 'Material', 'rian-cullet' ),
		'title'   => __( 'Glass cullet', 'rian-cullet' ),
		'lede'    => __( 'Recycled or broken glass, processed and prepared for melting and reuse in the production of new glass products.', 'rian-cullet' ),
	)
);
?>

<section class="rc-section rc-section--flush-top rc-surface-paper" aria-labelledby="rc-what-is-cullet">
	<div class="rc-container rc-container--wide">
		<div class="rc-split rc-split--7-5">

			<div class="rc-reveal">
				<h2 class="rc-display-3" id="rc-what-is-cullet"><?php esc_html_e( 'What is glass cullet?', 'rian-cullet' ); ?></h2>

				<div class="rc-stack" style="margin-top:var(--rc-space-6)">
					<p class="rc-body">
						<?php esc_html_e( 'Glass cullet is recycled or broken glass that has been processed and prepared for melting and reuse in the production of new glass products.', 'rian-cullet' ); ?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'Cullet plays an important role in the glass manufacturing process. Used as a raw material, it helps reduce the furnace melting temperature, lower energy consumption and reduce CO2 emissions. It therefore supports both the economic efficiency of glass manufacturing and environmental sustainability.', 'rian-cullet' ); ?>
					</p>
					<p class="rc-body">
						<?php esc_html_e( 'Cullet is commonly divided into two categories according to where it comes from: cullet generated inside a manufacturing plant, and cullet recovered after consumption.', 'rian-cullet' ); ?>
					</p>
				</div>
			</div>

			<div class="rc-reveal" style="--rc-i:1">
				<?php
				rc_figure(
					array(
						'name'   => 'intro-cullet-macro',
						'alt'    => __( 'Close-up of processed glass cullet prepared for melting.', 'rian-cullet' ),
						'ratio'  => 'rc-ratio-portrait',
						'class'  => 'rc-zoom',
						'width'  => 1200,
						'height' => 1500,
						'note'   => __( 'Processed cullet close-up, 4:5 portrait.', 'rian-cullet' ),
					)
				);
				?>
			</div>

		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/sections/product' ); ?>

<section class="rc-section rc-surface-paper" aria-labelledby="rc-glass-forms">
	<div class="rc-container rc-container--wide">

		<div class="rc-section-head rc-reveal">
			<?php rc_eyebrow( __( 'Forms', 'rian-cullet' ) ); ?>
			<h2 class="rc-display-2" id="rc-glass-forms"><?php esc_html_e( 'Container glass and flat glass', 'rian-cullet' ); ?></h2>
			<p class="rc-lede"><?php esc_html_e( 'Cullet of either type may arrive in either form, and each is sorted accordingly.', 'rian-cullet' ); ?></p>
		</div>

		<div class="rc-cols rc-cols--2 rc-ruled-cols" style="margin-top:var(--rc-space-8)">
			<div class="rc-reveal" style="--rc-i:0">
				<span class="rc-index">01</span>
				<h3 class="rc-h3 rc-why__title"><?php esc_html_e( 'Container glass', 'rian-cullet' ); ?></h3>
				<p class="rc-body"><?php esc_html_e( 'Glass formed into containers, such as bottles and jars. It arrives both as factory cullet from container plants and as post-consumer cullet recovered from municipal waste streams.', 'rian-cullet' ); ?></p>
			</div>
			<div class="rc-reveal" style="--rc-i:1">
				<span class="rc-index">02</span>
				<h3 class="rc-h3 rc-why__title"><?php esc_html_e( 'Flat glass', 'rian-cullet' ); ?></h3>
				<p class="rc-body"><?php esc_html_e( 'Glass produced in sheet form. It arrives as factory cullet generated during flat glass manufacturing, and as foreign cullet collected after use.', 'rian-cullet' ); ?></p>
			</div>
		</div>

	</div>
</section>

<?php
get_template_part( 'template-parts/sections/colour' );
get_template_part( 'template-parts/sections/why' );
get_template_part( 'template-parts/sections/cta' );

get_footer();
