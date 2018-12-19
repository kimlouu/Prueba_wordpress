<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package oceanica-lite
 */
?>
</div><!-- #content -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="wrapper">
		<?php get_sidebar( 'content-bottom' ); ?>
		<?php if ( has_nav_menu( 'menu-4' ) ) : ?>
			<nav class="footer-navigation clear" role="navigation"
			     aria-label="<?php esc_attr_e( 'Footer Links Menu', 'oceanica-lite' ); ?>">
				<?php wp_nav_menu( array(
					'theme_location' => 'menu-4',
					'menu_id'        => 'footer-navigation',
					'menu_class'     => 'theme-social-menu',
					'depth'          => 1,
					'link_before'    => '<span class="menu-text">',
					'link_after'     => '</span>'
				) ); ?>
			</nav><!-- .footer-navigation -->
		<?php endif; ?>
		<div class="site-info">
			<?php
			printf( esc_html__( '&copy; %1$s All Rights Reserved', 'oceanica-lite' ), ( new DateTime )->format( "Y" ) );
			?>
		</div><!-- .site-info -->
	</div><!-- .wrapper -->
</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>