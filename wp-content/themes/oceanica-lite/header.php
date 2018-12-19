<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package oceanica-lite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'oceanica-lite' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="wrapper">
			<div class="header-bar clear">
				<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
					<nav class="top-navigation" role="navigation"
					     aria-label="<?php esc_attr_e( 'Top Links Menu', 'oceanica-lite' ); ?>">
						<?php wp_nav_menu( array(
							'theme_location' => 'menu-2',
							'menu_id'        => 'top-navigation',
							'menu_class'     => 'theme-social-menu',
							'container_class' => 'menu-top-left-container',
							'link_before'    => '<span class="menu-text">',
							'link_after'     => '</span>'
						) ); ?>
					</nav>
				<?php endif; ?>
				<?php if ( has_nav_menu( 'menu-3' ) ) : ?>
					<nav class="top-navigation-right" role="navigation"
					     aria-label="<?php esc_attr_e( 'Top Links Menu', 'oceanica-lite' ); ?>">
						<?php wp_nav_menu( array(
							'theme_location' => 'menu-3',
							'menu_class'     => 'theme-social-menu',
							'menu_id'        => 'top-navigation-right',
							'container_class' => 'menu-top-right-container',
							'link_before'    => '<span class="menu-text">',
							'link_after'     => '</span>'
						) ); ?>
					</nav>
				<?php endif; ?>
                <?php do_action('oceanica_header');?>
			</div>
			<div class="site-header-main">
				<div class="site-branding">
					<div class="site-logo-wrapper">
						<?php oceanica_the_custom_logo(); ?>
						<div class="site-title-wrapper">
							<?php if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
								                          rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
								                         rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							endif;
							$description = apply_filters( 'oceanica_tagline', get_bloginfo( 'description', 'display' ) );
							if ( $description || is_customize_preview() ) : ?>
								<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
								<?php
							endif; ?>
						</div>
					</div>
				</div><!-- .site-branding -->
				<?php if ( has_nav_menu( 'menu-1' ) || has_nav_menu( 'menu-2' ) || has_nav_menu( 'menu-3' ) ) : ?>
					<div class="site-header-menu" id="site-header-menu">
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<div class="menu-toggle-wrapper">
								<button class="menu-toggle" aria-controls="primary-menu"
								        aria-expanded="false"><i class="fa fa-bars" aria-hidden="true"></i>
									<span><?php esc_html_e( 'Menu', 'oceanica-lite' ); ?></span></button>
							</div> <!--- .menu-toggle-wrapper -->
							<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
								<?php wp_nav_menu( array(
									'theme_location' => 'menu-1',
									'container_class' => 'menu-primary-container',
									'menu_id'        => 'primary-menu',
									'link_before'    => '<span class="menu-text">',
									'link_after'     => '</span>'
								) ); ?>
							<?php endif; ?>
							<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
								<?php wp_nav_menu( array(
									'theme_location' => 'menu-2',
									'menu_id'        => 'top-navigation-mobile',
									'menu_class'     => 'top-navigation-mobile theme-social-menu',
									'container_class' => 'menu-top-left-container',
									'link_before'    => '<span class="menu-text">',
									'link_after'     => '</span>'
								) ); ?>
							<?php endif; ?>
							<?php if ( has_nav_menu( 'menu-3' ) ) : ?>
								<?php wp_nav_menu( array(
									'theme_location' => 'menu-3',
									'menu_id'        => 'top-navigation-right-mobile',
									'menu_class'     => 'top-navigation-right-mobile theme-social-menu',
									'container_class' => 'menu-top-right-container',
									'link_before'    => '<span class="menu-text">',
									'link_after'     => '</span>'
								) ); ?>
							<?php endif; ?>
						</nav><!-- #site-navigation -->
					</div>
				<?php endif; ?>
			</div>
		</div>
	</header><!-- #masthead -->
	<div id="content" class="site-content ">
