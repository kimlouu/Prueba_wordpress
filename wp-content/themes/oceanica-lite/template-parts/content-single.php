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
	<header class="entry-header">
		<?php if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		oceanica_excerpt();
		if ( 'post' === get_post_type() ) { ?>
			<div class="entry-meta">
				<?php oceanica_posted_on(); ?>
			</div><!-- .entry-meta-->
		<?php } ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php
		the_content( sprintf(
		/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'oceanica-lite' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );
		oceanica_the_tags();
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
				'<div class="clear"></div><span class="edit-link">',
				'</span>'
			);
		endif; ?>
	</div><!-- .entry-content -->

	<?php oceanica_related_posts( $post ); ?>

	<?php if ( is_single() && get_the_author_meta( 'description' ) && 'post' === get_post_type() ) :
		get_template_part( 'template-parts/biography' );
	endif;
	?>
</article><!-- #post-## -->