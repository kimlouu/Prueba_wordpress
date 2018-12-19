<?php
/**
 * The template for the content bottom widget areas on posts and pages
 *
 * @package oceanica-lite
 */

// If we get this far, we have widgets. Let's do this.
?>
<?php if ( is_active_sidebar( 'sidebar-2' )||is_active_sidebar( 'sidebar-3' ) ||is_active_sidebar( 'sidebar-4' )  ) : ?>
<aside id="content-bottom-widgets" class="content-bottom-widgets" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>
	<div class="clear"></div>
</aside><!-- .content-bottom-widgets -->
<?php endif;