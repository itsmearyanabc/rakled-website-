<?php
/**
 * Section 08: Founder.
 *
 * No portrait, by decision. Rather than leaving a gap where an image
 * used to sit, the section is composed as a deliberate quiet moment:
 * a narrow measure inside a wide page, bounded by hairlines, sitting
 * between the dense "why" columns and the dark heritage block.
 *
 * The words carry it. That is the point.
 *
 * All copy is the client's own wording. No qualifications, awards or
 * personal history are added.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;
?>
<section class="rc-section rc-surface-paper rc-founder" aria-labelledby="rc-founder-title">
	<div class="rc-container rc-container--wide">
		<hr class="rc-rule">
	</div>

	<div class="rc-container rc-container--text rc-founder__inner">

		<div class="rc-reveal">
			<?php rc_eyebrow( __( 'Our story', 'rian-cullet' ) ); ?>

			<h2 class="rc-display-2 rc-founder__statement" id="rc-founder-title">
				<?php
				/* translators: %d: founding year */
				printf( esc_html__( 'A vision that began in %d.', 'rian-cullet' ), (int) RC_FOUNDED );
				?>
			</h2>
		</div>

		<div class="rc-founder__body rc-stack rc-reveal" style="--rc-i:1">
			<p class="rc-body">
				<?php esc_html_e( 'The journey of Rian Cullet is driven by the vision and leadership of its founder, Ms. Indu Bhatia. With a strong focus on sustainability and responsible waste management, she established the foundation for a business dedicated to transforming waste glass into a valuable and reusable resource.', 'rian-cullet' ); ?>
			</p>
			<p class="rc-body">
				<?php esc_html_e( 'Her vision has been to create a reliable source of quality glass cullet for the glass manufacturing industry while contributing towards a cleaner and more sustainable environment.', 'rian-cullet' ); ?>
			</p>
		</div>

		<div class="rc-founder__signature rc-reveal" style="--rc-i:2">
			<p class="rc-founder__name"><?php esc_html_e( 'Ms. Indu Bhatia', 'rian-cullet' ); ?></p>
			<p class="rc-founder__role"><?php esc_html_e( 'Founder, Rian Cullet', 'rian-cullet' ); ?></p>
		</div>

		<?php if ( ! is_page( 'about' ) ) : ?>
			<p class="rc-founder__more rc-reveal" style="--rc-i:3">
				<a class="rc-link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">
					<?php esc_html_e( 'Read our story', 'rian-cullet' ); ?>
					<span class="rc-btn__arrow" aria-hidden="true">&rarr;</span>
				</a>
			</p>
		<?php endif; ?>

	</div>

	<div class="rc-container rc-container--wide">
		<hr class="rc-rule">
	</div>
</section>
