<?php
/**
 * Site navigation.
 *
 * The header begins transparent over the hero and resolves to a solid
 * bar on scroll. nav.js additionally flips it to the light-on-dark
 * treatment whenever a section marked data-nav="dark" passes beneath it.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$rc_has_hero = is_front_page();
?>
<header class="rc-header<?php echo $rc_has_hero ? ' rc-header--over-hero' : ' is-solid'; ?>" data-rc-header>
	<div class="rc-header__inner rc-container rc-container--wide">

		<a class="rc-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php rc_logo_mark(); ?>
			<span class="rc-wordmark__text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
		</a>

		<nav class="rc-nav" aria-label="<?php esc_attr_e( 'Primary', 'rian-cullet' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'rc-nav__list',
						'depth'          => 1,
					)
				);
			} else {
				rc_fallback_menu( 'rc-nav__list' );
			}
			?>
		</nav>

		<div class="rc-header__actions">
			<?php
			rc_button(
				array(
					'label'   => __( 'Enquire', 'rian-cullet' ),
					'url'     => home_url( '/contact/' ),
					'variant' => 'secondary',
					'arrow'   => false,
					'class'   => 'rc-header__cta',
				)
			);
			?>

			<button
				type="button"
				class="rc-burger"
				data-rc-burger
				aria-expanded="false"
				aria-controls="rc-nav-overlay"
			>
				<span class="rc-burger__label"><?php esc_html_e( 'Menu', 'rian-cullet' ); ?></span>
				<span class="rc-burger__bars" aria-hidden="true"><span></span><span></span></span>
			</button>
		</div>

	</div>
</header>

<div class="rc-nav-overlay rc-surface-ink" id="rc-nav-overlay" data-rc-overlay hidden>
	<nav class="rc-nav-overlay__inner rc-container" aria-label="<?php esc_attr_e( 'Mobile', 'rian-cullet' ); ?>">
		<ul class="rc-nav-overlay__list">
			<?php foreach ( rc_nav_items() as $i => $rc_item ) : ?>
				<li class="rc-nav-overlay__item" style="--rc-i:<?php echo (int) $i; ?>">
					<a class="rc-nav-overlay__link" href="<?php echo esc_url( home_url( $rc_item['path'] ) ); ?>">
						<?php echo esc_html( $rc_item['label'] ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="rc-nav-overlay__foot">
			<?php
			rc_button(
				array(
					'label'   => __( 'Send an enquiry', 'rian-cullet' ),
					'url'     => home_url( '/contact/' ),
					'variant' => 'primary',
				)
			);
			?>
		</div>
	</nav>
</div>
