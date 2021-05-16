<?php
/**
 * Template part for displaying posts
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
	<div class="featured-image">
		<?php if ( ! is_single() ) : ?>
		<a href="<?php the_permalink(); ?>">
		<?php endif; ?>
			<?php the_post_thumbnail( 'paropakar-featured-image' ); ?>
		<?php if ( ! is_single() ) : ?>
		</a>
		<?php endif; ?>
	</div><!-- .featured-image -->

	<div class="row">
			<div class="entry-header">
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
						paropakar_post_comments();
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
						paropakar_post_comments();
					};
					echo '</div><!-- .entry-meta -->';
				};
				?>
			</div><!-- .entry-header -->

			<div class="entry-content">
				<?php
				if ( class_exists( 'Give' ) && ! is_home() && ! is_single() && ! is_author() && ! is_category() ) :
					global $post;
					global $args;
					$paropakar_postid = $post->ID;
					echo esc_attr( give_form_display_content( $paropakar_postid, $args ) );
					echo esc_attr( give_show_goal_progress( $paropakar_postid, $args ) );
					?>
					<a class="donate_link" href = "<?php echo esc_url( get_permalink( $paropakar_postid ) ); ?>" ><?php esc_attr__( 'Donate', 'paropakar' ); ?></a>
					<?php
				endif;

				/* translators: %s: Name of current post */
				the_content(
					sprintf(
						esc_attr__( 'Continue Reading', 'paropakar' )
					)
				);

				wp_link_pages(
					array(
						'before'      => '<div class="page-links">' . esc_attr__( 'Pages:', 'paropakar' ),
						'after'       => '</div>',
						'link_before' => '<span class="page-number">',
						'link_after'  => '</span>',
					)
				);
				?>
			</div><!-- .entry-content -->

			<?php
			if ( is_single() ) {
				paropakar_entry_footer();
			}
			?>
		</div>

</article><!-- #post-## -->
