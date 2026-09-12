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
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
					)
				);
			} else {
				// Fallback elegante com links diretos
				?>
				<ul class="fallback-menu">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
					<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
						<li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Loja / Catálogo</a></li>
					<?php endif; ?>
				</ul>
				<?php
			}
			?>
		</nav>

		<div class="header-actions">
			<?php targetlink_woo_cart_link(); ?>
		</div>
	</header>

	<main id="primary" class="site-main">
