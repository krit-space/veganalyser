<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<div class="page-heading">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</div>
		<?php else : ?>
		<div class="page-heading">
			<h1 class="page-title"><?php esc_html_e( 'Posts', 'paropakar' ); ?></h1>
		</div>
		<?php endif; ?>
	<div class="row <?php echo esc_html( $paropakar_class ); ?>">
		<?php
		if ( ! is_active_sidebar( 'sidebar-1' ) || 'null' === $paropakar_sidebar_position || empty( $paropakar_sidebar_position ) ) :
			?>
			<div id="main-col" class="col-lg-12">
		<?php else : ?>
			<div id="main-col" class="col-lg-8">
		<?php endif; ?>
			<div id="main" class="site-main" role="main">

				<?php
				if ( have_posts() ) :

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/post/content', get_post_format() );

					endwhile;

					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => __( '&#8592; Previous', 'paropakar' ),
							'next_text' => __( 'Next &#8594;', 'paropakar' ),
						)
					);

				else :

					get_template_part( 'template-parts/post/content', 'none' );

				endif;
				?>

			</div><!-- #main -->
		</div><!-- #main-col -->
		<?php
		if ( 'left' === $paropakar_sidebar_position || 'right' === $paropakar_sidebar_position ) :
			get_sidebar();
		endif;
		?>
	</div><!-- .row -->
</div>

<?php
get_footer();
