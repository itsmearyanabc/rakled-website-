<?php
/**
 * Default page template.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part(
		'template-parts/sections/page-hero',
		null,
		array( 'title' => get_the_title() )
	);

	if ( get_the_content() ) :
		?>
		<section class="rc-section rc-section--flush-top rc-surface-paper">
			<div class="rc-container rc-container--text rc-entry">
				<?php the_content(); ?>
			</div>
		</section>
		<?php
	endif;

endwhile;

get_template_part( 'template-parts/sections/cta' );

get_footer();
