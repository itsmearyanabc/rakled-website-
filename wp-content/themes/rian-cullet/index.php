<?php
/**
 * Fallback template.
 *
 * This site is a six-page brochure with no blog, so index.php exists to
 * satisfy the template hierarchy and to handle anything unexpected
 * gracefully rather than to present an archive.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="rc-section rc-surface-paper" style="padding-top:calc(var(--rc-header-h) + var(--rc-space-9))">
	<div class="rc-container rc-container--text">

		<?php if ( have_posts() ) : ?>

			<div class="rc-section-head">
				<?php rc_eyebrow( __( 'Index', 'rian-cullet' ) ); ?>
				<h1 class="rc-display-2"><?php echo esc_html( wp_get_document_title() ); ?></h1>
			</div>

			<div class="rc-stack--lg" style="margin-top:var(--rc-space-8)">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article class="rc-timeline__item">
						<h2 class="rc-h3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="rc-body"><?php echo esc_html( get_the_excerpt() ); ?></p>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>

		<?php else : ?>

			<div class="rc-section-head">
				<h1 class="rc-display-2"><?php esc_html_e( 'Nothing found', 'rian-cullet' ); ?></h1>
				<p class="rc-lede"><?php esc_html_e( 'There is nothing here yet.', 'rian-cullet' ); ?></p>
			</div>

		<?php endif; ?>

	</div>
</section>
<?php
get_footer();
