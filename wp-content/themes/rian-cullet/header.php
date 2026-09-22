<?php
/**
 * Site header.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="rc-skip-link" href="#rc-main"><?php esc_html_e( 'Skip to content', 'rian-cullet' ); ?></a>

<?php get_template_part( 'template-parts/header/nav' ); ?>

<main id="rc-main" class="rc-main">
