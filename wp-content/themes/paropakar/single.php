<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

get_header(); ?>

<div class="container">
<?php
$paropakar_sidebar_position = get_theme_mod( 'paropakar_sidebar_option' );
	$paropakar_class        = '';
if ( is_active_sidebar( 'sidebar-1' ) ) :
	if ( 'left' === $paropakar_sidebar_position ) :
		$paropakar_class = 'left-sidebar';
		endif;
	endif;
?>

<div class="row <?php echo esc_html( $paropakar_class ); ?>">
	<?php if ( ! is_active_sidebar( 'sidebar-1' ) || 'null' === $paropakar_sidebar_position || empty( $paropakar_sidebar_position ) ) { ?>
		<div id="main-col" class="col-lg-12 single-col">
	<?php } else { ?>
		<div id="main-col" class="col-lg-8 single-col">
	<?php } ?>
		<div id="main" class="site-main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/post/content', get_post_format() );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				the_post_navigation(
					array(
						'prev_text' => '<i class = "fa fa-angle-double-left" ></i>',

						'next_text' => '<i class = "fa fa-angle-double-right" ></i>',
					)
				);

			endwhile; // End of the loop.
			?>

		</div><!-- #main -->
	</div><!-- .col-sm-7 -->
	<?php
	if ( 'left' === $paropakar_sidebar_position || 'right' === $paropakar_sidebar_position ) :
			get_sidebar();
		endif;
	?>
</div><!-- .row -->
</div>

<?php
get_footer();
