<?php
/**
 * Template part for displaying gallery posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() && ! get_post_gallery() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'paropakar-featured-image' ); ?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>

	<header class="entry-header">
		<?php

		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} elseif ( is_front_page() && is_home() ) {
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		if ( 'post' === get_post_type() ) {
			echo '<div class="entry-meta">';
			if ( is_single() ) {
				paropakar_posted_on();
			} else {
				paropakar_edit_link();
				echo wp_kses(
					paropakar_time_link(),
					array(
						'time' => array(
							'class' => array(),
						),
						'span' => array(
							'class' => array(),
						),
						'a'    => array(
							'href' => array(),
							'rel'  => array(),
						),
					)
				);
			};
			echo '</div><!-- .entry-meta -->';
		};
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
		if ( ! is_single() ) {

			// If not a single post, highlight the gallery.
			if ( get_post_gallery() ) {
				echo '<div class="entry-gallery">';
				echo wp_kses(
					get_post_gallery(),
					array(
						'div'    => array(
							'class' => array(),
							'id'    => array(),
						),
						'figure' => array(
							'class' => array(),
						),
						'a'      => array(
							'href' => array(),
						),
						'img'    => array(
							'src'    => array(),
							'width'  => array(),
							'height' => array(),
							'class'  => array(),
							'alt'    => array(),
							'srcset' => array(),
							'sizes'  => array(),
						),
					)
				);
				echo '</div>';
			};

		};

		if ( is_single() || ! get_post_gallery() ) {

			the_content(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'paropakar' ),
					get_the_title()
				)
			);

			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . __( 'Pages:', 'paropakar' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);

		};
		?>

	</div><!-- .entry-content -->

	<?php
	if ( is_single() ) {
		paropakar_entry_footer();
	}
	?>

</article><!-- #post-## -->
