<?php
/**
 * Section 01: Hero.
 *
 * A rotating hero. Two deliberately different motions run here so the
 * change never reads as one single effect:
 *
 *   Photography  cross-dissolves, with a slow continuous scale.
 *   The tagline  leaves upward and arrives from below, line by line,
 *                each line masked by its own clipping frame.
 *
 * Slide one is the primary SEO headline and the only image loaded
 * eagerly. Every tagline is real text in the DOM, so the content is
 * complete for crawlers and for anyone without JavaScript.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_slides = rc_hero_slides();
?>
<section class="rc-hero" data-rc-hero data-nav="dark">

	<div class="rc-hero__media rc-scrim">
		<?php foreach ( $rc_slides as $rc_i => $rc_slide ) : ?>
			<div class="rc-hero__slide<?php echo 0 === $rc_i ? ' is-active' : ''; ?>" data-rc-slide="<?php echo (int) $rc_i; ?>">
				<?php
				rc_figure(
					array(
						'name'     => $rc_slide['image'],
						'alt'      => 0 === $rc_i ? $rc_slide['alt'] : '',
						'ratio'    => '',
						'tag'      => 'div',
						'priority' => 0 === $rc_i,
						'width'    => 2400,
						'height'   => 1350,
						'note'     => $rc_slide['note'],
					)
				);
				?>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="rc-hero__inner rc-container rc-container--wide">
		<div class="rc-hero__content">

			<div class="rc-reveal" style="--rc-i:0">
				<?php rc_eyebrow( __( 'Glass Cullet / Pan-India Supply', 'rian-cullet' ) ); ?>
			</div>

			<h1 class="rc-display-1 rc-hero__title">
				<?php foreach ( $rc_slides as $rc_i => $rc_slide ) : ?>
					<span
						class="rc-tagline<?php echo 0 === $rc_i ? ' is-active' : ''; ?>"
						data-rc-tagline="<?php echo (int) $rc_i; ?>"
						<?php echo 0 === $rc_i ? '' : 'aria-hidden="true"'; ?>
					>
						<?php foreach ( array_values( $rc_slide['lines'] ) as $rc_l => $rc_line ) : ?>
							<span class="rc-tagline__line" style="--rc-i:<?php echo (int) $rc_l; ?>"><span><?php echo esc_html( $rc_line ); ?></span></span>
						<?php endforeach; ?>
					</span>
				<?php endforeach; ?>
			</h1>

			<p class="rc-lede rc-hero__lede rc-reveal" style="--rc-i:4">
				<?php esc_html_e( 'We collect, sort and process glass cullet for reuse in the glass manufacturing cycle.', 'rian-cullet' ); ?>
			</p>

			<div class="rc-hero__actions rc-reveal" style="--rc-i:5">
				<?php
				rc_button(
					array(
						'label' => __( 'Explore our cullet', 'rian-cullet' ),
						'url'   => home_url( '/glass-cullet/' ),
					)
				);
				rc_button(
					array(
						'label'   => __( 'Our story', 'rian-cullet' ),
						'url'     => home_url( '/about/' ),
						'variant' => 'secondary',
						'arrow'   => false,
					)
				);
				?>
			</div>

			<?php
			/*
			 * WCAG 2.2.2 (Pause, Stop, Hide). The rotation starts on its
			 * own and runs longer than five seconds, so a control to stop
			 * it is required, not optional. The bars double as the timer
			 * and as direct navigation.
			 */
			?>
			<div class="rc-hero__controls rc-reveal" style="--rc-i:6" data-rc-hero-controls>
				<button type="button" class="rc-hero__toggle" data-rc-hero-toggle aria-pressed="false">
					<span class="rc-hero__toggle-icon" aria-hidden="true"></span>
					<span class="rc-hero__toggle-text"><?php esc_html_e( 'Pause', 'rian-cullet' ); ?></span>
				</button>

				<ol class="rc-hero__bars">
					<?php foreach ( $rc_slides as $rc_i => $rc_slide ) : ?>
						<li class="rc-hero__bar-item">
							<button
								type="button"
								class="rc-hero__bar<?php echo 0 === $rc_i ? ' is-active' : ''; ?>"
								data-rc-goto="<?php echo (int) $rc_i; ?>"
								<?php echo 0 === $rc_i ? 'aria-current="true"' : ''; ?>
							>
								<span class="rc-sr-only">
									<?php
									printf(
										/* translators: 1: slide number, 2: total slides */
										esc_html__( 'Show slide %1$d of %2$d', 'rian-cullet' ),
										(int) $rc_i + 1,
										count( $rc_slides )
									);
									?>
								</span>
								<span class="rc-hero__bar-fill" aria-hidden="true"></span>
							</button>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>

			<p class="rc-hero__cue rc-reveal" style="--rc-i:7">
				<?php esc_html_e( 'Scroll to discover', 'rian-cullet' ); ?>
				<span aria-hidden="true">&darr;</span>
			</p>

		</div>
	</div>
</section>
