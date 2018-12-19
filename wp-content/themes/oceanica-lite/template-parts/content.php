<?php
/**
 * Template part for displaying posts
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
		<div class="entry-content">
			<?php the_content( sprintf(
			/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'oceanica-lite' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
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
			endif;
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-wrapper -->
	<footer class="entry-footer">
		<div class="entry-meta">
			<?php oceanica_posted_on(); ?>
		</div><!-- .entry-meta-->
	</footer><!-- .entry-footer -->
	<div class="clear"></div>
</article><!-- #post-## -->