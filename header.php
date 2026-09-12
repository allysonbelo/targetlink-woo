<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site-wrapper">
	<header class="site-header">
		<div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php else : ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <p class="site-description"><?php bloginfo( 'description' ); ?></p>
            <?php endif; ?>
		</div>

		<nav class="main-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
                    'fallback_cb'    => false, // não mostra nada se não houver menu
				)
			);
			?>
		</nav>
	</header>

	<main id="primary" class="site-main">
