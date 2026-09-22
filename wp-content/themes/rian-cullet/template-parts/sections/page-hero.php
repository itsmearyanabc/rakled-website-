<?php
/**
 * Inner page header.
 *
 * Deliberately not a full-viewport hero. Only the homepage earns that;
 * on inner pages it would delay the content the visitor came for.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_args = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow' => '',
		'title'   => get_the_title(),
		'lede'    => '',
	)
);
?>
<section class="rc-section rc-section--tight rc-surface-paper rc-page-hero" style="padding-top:calc(var(--rc-header-h) + var(--rc-space-9))">
	<div class="rc-container rc-container--wide">
		<div class="rc-section-head rc-reveal">
			<?php
			if ( $rc_args['eyebrow'] ) {
				rc_eyebrow( $rc_args['eyebrow'] );
			}
			?>
			<h1 class="rc-display-1" style="font-size:var(--rc-size-h2)"><?php echo esc_html( $rc_args['title'] ); ?></h1>
			<?php if ( $rc_args['lede'] ) : ?>
				<p class="rc-lede"><?php echo esc_html( $rc_args['lede'] ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
