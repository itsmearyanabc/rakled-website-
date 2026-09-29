<?php
/**
 * Section 05: Product.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_products = array(
	array(
		'index' => '01',
		'name'  => __( 'Factory Cullet', 'rian-cullet' ),
		'lead'  => __( 'Glass generated during manufacturing.', 'rian-cullet' ),
		'body'  => __( 'Factory cullet is produced inside flat glass or container glass plants. It is the glass waste that arises during the manufacturing process itself, in either the flat glass or the container glass industry.', 'rian-cullet' ),
		'image' => 'factory-cullet',
		'alt'   => __( 'Large piles of glass cullet in the yard of a glass manufacturing plant.', 'rian-cullet' ),
		'note'  => __( 'Product: factory cullet with the plant behind it, 4:5 portrait. 1200x1500.', 'rian-cullet' ),
	),
	array(
		'index' => '02',
		'name'  => __( 'Foreign Cullet', 'rian-cullet' ),
		'lead'  => __( 'Post-consumer glass, recovered for reuse.', 'rian-cullet' ),
		'body'  => __( 'Foreign cullet, also known as external or post-consumer cullet, is waste glass collected after consumption. It may be container glass or flat glass, gathered from municipal waste streams and other relevant sources.', 'rian-cullet' ),
		'image' => 'foreign-cullet',
		'alt'   => __( 'Post-consumer foreign cullet sorted for processing.', 'rian-cullet' ),
		'note'  => __( 'Product: foreign post-consumer cullet, 4:5 portrait. 1200x1500.', 'rian-cullet' ),
	),
	array(
		'index' => '03',
		'name'  => __( 'Flint (White) Cullet', 'rian-cullet' ),
		'lead'  => __( 'Clear, colourless glass, kept apart from colour.', 'rian-cullet' ),
		'body'  => __( 'Flint is the glass trade’s name for clear, colourless glass. Flint cullet is sorted and processed separately from amber and green glass, which keeps it suitable for the production of clear glass.', 'rian-cullet' ),
		'image' => 'flint-cullet',
		'alt'   => __( 'Clear flint glass cullet, crushed and sorted.', 'rian-cullet' ),
		'note'  => __( 'Product: flint (white) cullet, 4:5 portrait. 1200x1500.', 'rian-cullet' ),
	),
);
?>
<section class="rc-section rc-surface-paper" aria-labelledby="rc-product-title">
	<div class="rc-container rc-container--wide">

		<div class="rc-section-head rc-reveal">
			<?php rc_eyebrow( __( 'Material', 'rian-cullet' ) ); ?>
			<h2 class="rc-display-2" id="rc-product-title"><?php esc_html_e( 'Our glass cullet', 'rian-cullet' ); ?></h2>
			<p class="rc-lede"><?php esc_html_e( 'Processed glass. Ready for its next cycle.', 'rian-cullet' ); ?></p>
		</div>

		<div class="rc-products rc-cols rc-cols--3">
			<?php foreach ( $rc_products as $rc_i => $rc_product ) : ?>
				<a class="rc-card rc-reveal" href="<?php echo esc_url( home_url( '/glass-cullet/' ) ); ?>" style="--rc-i:<?php echo (int) $rc_i; ?>">
					<div class="rc-card__body">
						<div class="rc-product__meta">
							<h3 class="rc-h3"><?php echo esc_html( $rc_product['name'] ); ?></h3>
							<span class="rc-index"><?php echo esc_html( $rc_product['index'] ); ?></span>
						</div>
						<p class="rc-lede" style="font-size:var(--rc-size-body)"><?php echo esc_html( $rc_product['lead'] ); ?></p>
					</div>

					<div class="rc-product__media">
						<?php
						rc_figure(
							array(
								'name'   => $rc_product['image'],
								'alt'    => $rc_product['alt'],
								'ratio'  => 'rc-ratio-portrait',
								'class'  => 'rc-zoom',
								'width'  => 1200,
								'height' => 1500,
								'note'   => $rc_product['note'],
							)
						);
						?>
					</div>

					<div class="rc-card__body">
						<p class="rc-body"><?php echo esc_html( $rc_product['body'] ); ?></p>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

	</div>
</section>
