<?php
/**
 * Section 06: Colour.
 *
 * The visual centrepiece. Three full-height panels of real glass, with
 * no filters or overlays: the material supplies the colour.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_colours = array(
	array(
		'name'  => __( 'Clear / White', 'rian-cullet' ),
		'image' => 'clear-glass',
		'alt'   => __( 'Clear glass cullet fragments in natural light.', 'rian-cullet' ),
		'note'  => __( 'Colour panel: clear and white cullet, 3:4. 1200x1600.', 'rian-cullet' ),
	),
	array(
		'name'  => __( 'Amber', 'rian-cullet' ),
		'image' => 'amber-glass',
		'alt'   => __( 'Amber glass cullet fragments in natural light.', 'rian-cullet' ),
		'note'  => __( 'Colour panel: amber cullet, 3:4. 1200x1600.', 'rian-cullet' ),
	),
	array(
		'name'  => __( 'Green', 'rian-cullet' ),
		'image' => 'green-glass',
		'alt'   => __( 'Green glass cullet fragments in natural light.', 'rian-cullet' ),
		'note'  => __( 'Colour panel: green cullet, 3:4. 1200x1600.', 'rian-cullet' ),
	),
);
?>
<section class="rc-section rc-surface-paper" aria-labelledby="rc-colour-title">
	<div class="rc-container rc-container--wide">
		<div class="rc-colour__head rc-section-head rc-reveal">
			<?php rc_eyebrow( __( 'Colour', 'rian-cullet' ) ); ?>
			<h2 class="rc-display-2" id="rc-colour-title"><?php esc_html_e( 'Every colour has another cycle.', 'rian-cullet' ); ?></h2>
			<p class="rc-lede"><?php esc_html_e( 'Cullet is sorted by colour because colour determines where the glass can go next.', 'rian-cullet' ); ?></p>
		</div>
	</div>

	<div class="rc-colour__panels rc-bleed">
		<?php foreach ( $rc_colours as $rc_i => $rc_colour ) : ?>
			<figure class="rc-panel rc-zoom rc-scrim rc-ratio-panel rc-reveal" style="--rc-i:<?php echo (int) $rc_i; ?>">
				<?php
				rc_figure(
					array(
						'name'   => $rc_colour['image'],
						'alt'    => $rc_colour['alt'],
						'ratio'  => '',
						'class'  => 'rc-panel__figure',
						'tag'    => 'div',
						'width'  => 1200,
						'height' => 1600,
						'note'   => $rc_colour['note'],
					)
				);
				?>
				<figcaption class="rc-panel__caption">
					<span class="rc-panel__name"><?php echo esc_html( $rc_colour['name'] ); ?></span>
					<span class="rc-panel__index"><?php echo esc_html( sprintf( '%02d', $rc_i + 1 ) ); ?></span>
				</figcaption>
			</figure>
		<?php endforeach; ?>
	</div>
</section>
