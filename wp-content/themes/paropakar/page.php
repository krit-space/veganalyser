<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
	$paropakar_class            = '';
	if ( is_active_sidebar( 'sidebar-1' ) ) :
		if ( 'left' === $paropakar_sidebar_position ) :
			$paropakar_class = 'left-sidebar';
		endif;
	endif;
	?>

	<div class="row <?php echo esc_html( $paropakar_class ); ?>">
		<?php if ( ! is_active_sidebar( 'sidebar-1' ) || 'null' === $paropakar_sidebar_position || empty( $paropakar_sidebar_position ) ) { ?>
			<div id="page-col" class="col-lg-12 single-col">
		<?php } else { ?>
			<div id="page-col" class="col-lg-8 single-col">
		<?php } ?>
			<main id="main" class="site-main">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/page/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</main><!-- #main -->
		</div><!-- #page-col -->
		<?php
		if ( 'left' === $paropakar_sidebar_position || 'right' === $paropakar_sidebar_position ) :
			get_sidebar();
		endif;
		?>
	</div><!-- .row -->
</div>

<?php
get_footer();
