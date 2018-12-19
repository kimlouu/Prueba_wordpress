<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package oceanica-lite
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php oceanica_excerpt(); ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oceanica-lite' ),
				'after'  => '</div>',
			) );
			if ( get_edit_post_link() ) :
				edit_post_link(
					sprintf(
					/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'oceanica-lite' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<div class="clear"></div><p class="edit-link">',
					'</p>'
				);
			endif; ?>
		</div><!-- .entry-content -->
	</article><!-- #post-## -->
