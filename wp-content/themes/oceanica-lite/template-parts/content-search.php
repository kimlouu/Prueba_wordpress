<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package oceanica-lite
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php oceanica_post_thumbnail(); ?>
		<div class="entry-wrapper">
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->
			<?php oceanica_excerpt(); ?>
		</div><!-- .entry-wrapper -->
		<footer class="entry-footer">
			<div class="entry-meta">
				<?php oceanica_posted_on(); ?>
			</div><!-- .entry-meta-->
		</footer><!-- .entry-footer -->
		<div class="clear"></div>
	</article><!-- #post-## -->