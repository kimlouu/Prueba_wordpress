<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package oceanica-lite
 */

if ( ! function_exists( 'oceanica_get_posted_on_by' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function oceanica_get_posted_on_by() {
		global $post;
		$string      = '';
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';


		$byline = sprintf(
			'<span class="by">' . esc_html_x( 'by %s', 'post author', 'oceanica-lite' ),
			'</span><span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		$string = '<span class="posted-on">' . $posted_on . '<span class="delimiter"></span></span><span class="byline">' . $byline . '<span class="delimiter"></span></span>'; // WPCS: XSS OK.
		return $string;
	}
endif;


if ( ! function_exists( 'oceanica_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time, author, categories.
	 */
	function oceanica_posted_on() {

		$posted_on_by = apply_filters( 'oceanica_get_posted_on_by', oceanica_get_posted_on_by() );

		if ( is_sticky() ) : ?>
			<div class="sticky-post-wrapper">
				<span class="sticky-post"><?php esc_html_e( 'Featured', 'oceanica-lite' ); ?></span>
			</div>
			<?php
		endif;

		if ( $posted_on_by != '' ) {
			echo $posted_on_by;
		}

		if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( sprintf( wp_kses(__( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'oceanica-lite' ), array( 'span' => array( 'class' => array() ) )), get_the_title() ) );
			echo '</span>';
		}
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( '<span class="category-delimiter">,</span> ' );
		if ( $categories_list && oceanica_categorized_blog() ) {
			printf( '<span class="cat-links"> %2$s<span class="cat-text">' . esc_html__( ' in ', 'oceanica-lite' ) . '</span> %1$s</span>', $categories_list, ''); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'oceanica_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function oceanica_entry_footer() {
		// Hide category and tag text for pages.


		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'oceanica-lite' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'oceanica-lite' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function oceanica_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'oceanica_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'oceanica_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so oceanica_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so oceanica_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in oceanica_categorized_blog.
 */
function oceanica_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'oceanica_categories' );
}

add_action( 'edit_category', 'oceanica_category_transient_flusher' );
add_action( 'save_post', 'oceanica_category_transient_flusher' );


if ( ! function_exists( 'oceanica_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function oceanica_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		if ( is_singular() ) :
			global $post;
			$thumb      = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'oceanica-thumb-large' );
			?>
			<div class="post-thumbnail" style="background-image: url(<?php echo esc_url( $thumb['0'] ); ?>);max-width:<?php echo $thumb['1']?>px;">
				<?php the_post_thumbnail( 'post-thumbnail' ); ?>
			</div><!-- .post-thumbnail -->
		<?php else : ?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php the_post_thumbnail( 'post-thumbnail' ); ?>
			</a>

		<?php endif; // End is_singular()
	}
endif;

if ( ! function_exists( 'oceanica_the_post_navigation' ) ) :
	/**
	 * Displays the post navigation.
	 */
	function oceanica_the_post_navigation() {
		the_post_navigation( array(
			'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'next', 'oceanica-lite' ) . '</span> ' .
			               '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'oceanica-lite' ) . '</span> ' .
			               '<span class="post-title">%title</span>',
			'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'previous', 'oceanica-lite' ) . '</span> ' .
			               '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'oceanica-lite' ) . '</span> ' .
			               '<span class="post-title">%title</span>'
		) );
	}
endif;

if ( ! function_exists( 'oceanica_the_posts_pagination' ) ) :
	/**
	 * Displays the post pagination.
	 */
	function oceanica_the_posts_pagination() {
		the_posts_pagination( array(
			'prev_text'          => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
			'next_text'          => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'oceanica-lite' ) . ' </span>',
			'mid_size'           => 2,
		) );
	}
endif;

if ( ! function_exists( 'oceanica_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own oceanica_excerpt() function to override in a child theme.
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function oceanica_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) :
			$excerpt = get_the_excerpt();
			if ( ! empty( $excerpt ) ) { ?>
				<div class="<?php echo $class; ?>">
					<?php echo $excerpt; ?>
				</div><!-- .<?php echo $class; ?> -->
			<?php }
		endif;
	}
endif;

if ( ! function_exists( 'oceanica_the_tags' ) ) :
	/**
	 * Displays post tags.
	 */
	function oceanica_the_tags() {
		if ( 'post' === get_post_type() ) {
			$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'Used between list items, there is a space.', 'oceanica-lite' ) );
			if ( $tags_list ) {
				printf( '<p class="tagcloud"><span class="tags-links"><span class="tags-title">%1$s </span><span class="screen-reader-text">%2$s </span>%3$s</span></p>',
					esc_html__( 'Tagged: ', 'oceanica-lite' ),
					esc_html_x( 'Tags', 'Used before tag names.', 'oceanica-lite' ),
					$tags_list
				);
			}
		}
	}
endif;


if ( ! function_exists( 'oceanica_excerpt_more' ) && ! is_admin() ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Continue reading' link.
	 *
	 * Create your own oceanica_excerpt_more() function to override in a child theme.
	 *
	 *
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	function oceanica_excerpt_more() {
		$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( wp_kses(__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'oceanica-lite' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title( get_the_ID() ) )
		);

		return ' &hellip; ' . $link;
	}

	add_filter( 'excerpt_more', 'oceanica_excerpt_more' );
endif;

if ( ! function_exists( 'oceanica_read_more' ) ) :
	/**
	 * Create your own oceanica_read_more() function to override in a child theme.
	 */
	function oceanica_read_more( $more_link, $more_link_text ) {

		return '<p>' . $more_link . '</p>';
	}

endif;

if ( ! function_exists( 'oceanica_child_pages' ) ) :
	/**
	 * Displays the page child pages.
	 */
	function oceanica_child_pages() {
		global $post;
		$args   = apply_filters( 'oceanica_child_pages_args', array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $post->ID,
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'ignore_sticky_posts' => 1,
				'meta_query'          => array( array( 'key' => '_thumbnail_id' ) )
			)
		);
		$parent = new WP_Query( $args );
		if ( $parent->have_posts() ) :?>
			<div class="entry-child-pages">
				<div class="entry-child-pages-wrapper">
					<?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if ( ! ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) ) { ?>
								<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
									<?php the_post_thumbnail( 'oceanica-thumb-medium' ); ?>
									<i class="fa fa-link" aria-hidden="true"></i>
								</a>
							<?php }
							the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
							?>
						</article><!-- #post-## -->
					<?php endwhile; ?>
				</div><!-- .entry-child-pages -->
			</div><!-- .entry-child-pages -->
		<?php endif;
		wp_reset_query();

	}

endif;

if ( ! function_exists( 'oceanica_child_pages_list' ) ) :
	/**
	 * Displays the page child pages.
	 */
	function oceanica_child_pages_list() {
		global $post;
		$args   = apply_filters( 'oceanica_child_pages_list_args', array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $post->ID,
				'order'          => 'ASC',
				'orderby'        => 'menu_order'
			)
		);
		$parent = new WP_Query( $args );
		if ( $parent->have_posts() ) :?>
			<div class="entry-child-pages-list">
				<div class="entry-child-pages-list-wrapper">
					<?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-wrapper">
								<?php if ( ! ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) ) { ?>
									<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
										<?php the_post_thumbnail( 'oceanica-thumb-medium' ); ?>
									</a>
								<?php }
								the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
								?>
								<?php
								add_filter( 'the_content_more_link', 'oceanica_read_more', 10, 2 );
								the_content( esc_html__( 'Read More', 'oceanica-lite' ) );
								remove_filter( 'the_content_more_link', 'oceanica_read_more', 10, 2 ); ?>
							</div><!-- .entry-wrapper -->
						</article><!-- #post-## -->
					<?php endwhile; ?>
				</div><!-- .entry-child-pages -->
			</div><!-- .entry-child-pages -->
		<?php endif;
		wp_reset_query();

	}

endif;
if ( ! function_exists( 'oceanica_last_news' ) ) :
	/**
	 * Displays last news.
	 */
	function oceanica_last_news() {
		$args = apply_filters( 'oceanica_last_news_args', array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'ignore_sticky_posts' => 1,
				'meta_query'          => array( array( 'key' => '_thumbnail_id' ) )
			)
		);

		$parent = new WP_Query( $args );
		$i      = 0;
		if ( $parent->have_posts() ) :?>
			<section class="last-news last-news-<?php echo $parent->post_count; ?>">
				<div class="last-news-wrapper">
					<div class="last-news-col">
						<?php while ( $parent->have_posts() ) :
						$parent->the_post();
						$i ++;
						if ( $i == 2 ) {
						?>
					</div><!--  .last-news-col -->
					<div class="last-news-col">
						<?php } ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if ( ! ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) ) { ?>
								<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
									<?php the_post_thumbnail( 'post-thumbnail' ); ?>
									<i class="fa fa-link" aria-hidden="true"></i>
								</a>
							<?php }
							the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
							?>
						</article><!-- #post-## -->
						<?php endwhile; ?>
					</div><!--  .last-news-col -->

				</div><!-- .entry-child-pages -->
			</section><!-- .entry-child-pages -->
		<?php endif;
		wp_reset_query();

	}

endif;

if ( ! function_exists( 'oceanica_related_posts' ) ) :
	/**
	 * Displays related posts
	 */
	function oceanica_related_posts( $post ) {
		if ( 'post' === get_post_type() ) {
			$tags = wp_get_post_tags( $post->ID );
			if ( $tags ) {
				$tag_ids = array();
				foreach ( $tags as $individual_tag ) {
					$tag_ids[] = $individual_tag->term_id;
				}
				$args     = array(
					'tag__in'        => $tag_ids,
					'post__not_in'   => array( $post->ID ),
					'posts_per_page' => 4
				);
				$my_query = new wp_query( $args );
				if ( $my_query->have_posts() ):
					?>
					<div class="related-posts">
						<h2 class="related-posts-title"><?php esc_html_e( 'Related Posts', 'oceanica-lite' ); ?></h2>
						<!-- .related-posts-title -->
						<ul>
							<?php
							while ( $my_query->have_posts() ) {
								$my_query->the_post();
								?>
								<li>
									<a href="<?php the_permalink() ?>" rel="bookmark"
									   title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</li>
							<?php } ?>
						</ul>
					</div><!-- .related-posts -->
					<?php
				endif;
				?>
				<?php
			}
			wp_reset_query();
		}
	}

endif;