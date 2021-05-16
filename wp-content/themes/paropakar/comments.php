<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$paropakar_comments_number = get_comments_number();
			if ( '1' === $paropakar_comments_number ) {
				/* translators: %s: post title */
				printf( esc_html_x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'paropakar' ), esc_html( get_the_title() ) );
			} else {
				printf(
					esc_html(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s Reply to &ldquo;%2$s&rdquo;',
							'%1$s Replies to &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'paropakar'
						)
					),
					esc_html( number_format_i18n( $comments_number ) ),
					esc_html( get_the_title() )
				);
			}
			?>
		</h2>

		<div class="comment-list">
			<?php
				wp_list_comments(
					array(
						'avatar_size' => 100,
						'style'       => 'ol',
						'short_ping'  => true,
						'reply_text'  => '<i class = "fa fa-reply" ></i>' . __( 'Reply', 'paropakar' ),
					)
				);
			?>
		</div>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => '<i class = "fa fa-chevron-left" ></i> <span class="screen-reader-text">' . __( 'Previous', 'paropakar' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'paropakar' ) . '</span> <i class = "fa fa-chevron-right" ></i>',
			)
		);

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'paropakar' ); ?></p>
		<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
