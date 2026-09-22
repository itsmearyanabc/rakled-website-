<?php
/**
 * Privacy policy.
 *
 * No content has been supplied. Rather than shipping boilerplate that
 * makes legal claims on the company's behalf, the page states plainly
 * that it is pending and inc/seo.php keeps it out of the index until
 * real text exists.
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
		'eyebrow' => __( 'Legal', 'rian-cullet' ),
		'title'   => __( 'Privacy policy', 'rian-cullet' ),
	)
);

while ( have_posts() ) :
	the_post();

	if ( get_the_content() ) :
		?>
		<section class="rc-section rc-section--flush-top rc-surface-paper">
			<div class="rc-container rc-container--text rc-entry"><?php the_content(); ?></div>
		</section>
		<?php
	else :
		?>
		<section class="rc-section rc-section--flush-top rc-surface-paper">
			<div class="rc-container rc-container--text">
				<p class="rc-notice">
					<?php esc_html_e( 'This policy has not been published yet. Add the content to this page in WordPress and it will replace this notice; the page is excluded from search engines until then.', 'rian-cullet' ); ?>
				</p>
			</div>
		</section>
		<?php
	endif;

endwhile;

get_footer();
