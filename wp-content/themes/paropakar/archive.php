<?php
/**
 * The template for displaying archive pages
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
		if ( 'left' === $sidebar_position ) :
			$paropakar_class = 'left-sidebar';
		endif;
	endif;
	?>

	<?php if ( have_posts() ) : ?>
		<header class="page-heading">
			<?php
				echo '<h1 class="page-title">' . single_cat_title( '', false ) . '</h1>';
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->
	<?php endif; ?>
	<div class="row <?php echo esc_html( $paropakar_class ); ?>">
		<?php if ( ! is_active_sidebar( 'sidebar-1' ) || 'null' === $sidebar_position || empty( $paropakar_sidebar_position ) ) : ?>
			<div id="archive-col" class="col-lg-12 single-col">
		<?php else : ?>
			<div id="archive-col" class="col-lg-8 single-col">
		<?php endif; ?>
			<div id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :
				?>
				<?php
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
						'prev_text'          => '<span class="screen-reader-text">' . __( 'Previous page', 'paropakar' ) . '</span>',
						'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'paropakar' ) . '</span>',
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'paropakar' ) . ' </span>',
					)
				);

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>

			</div><!-- #main -->
		</div><!-- #archive-col -->
		<?php
		if ( 'left' === $sidebar_position || 'right' === $sidebar_position ) :
			get_sidebar();
		endif;
		?>
	</div><!-- .row -->
</div>

<?php
get_footer();
