<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

get_header(); ?>

<?php
$paropakar_sidebar_position = get_theme_mod( 'paropakar_sidebar_option' );
if ( is_active_sidebar( 'sidebar-1' ) ) :
	if ( 'left' === $paropakar_sidebar_position ) :
		$paropakar_class = 'left-sidebar';
	elseif ( 'right' === $paropakar_sidebar_position ) :
		$paropakar_class = '';
	elseif ( '' === $paropakar_sidebar_position || 'null' === $paropakar_sidebar_position ) :
		$paropakar_class = '';
	endif;
endif;
?>

<div class="container">

	<div class="page-heading">
		<?php if ( have_posts() ) : ?>
			<?php /* translators: %s: search term */ ?>
			<h1 class="page-title"><?php printf( esc_html_e( 'Search Results for: %s', 'paropakar' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php else : ?>
			<h1 class="page-title"><?php esc_attr_e( 'Nothing Found', 'paropakar' ); ?></h1>
		<?php endif; ?>
	</div>
	<div class="row <?php echo esc_html( $paropakar_class ); ?>">
		<?php
		$paropakar_sidebar_position = $paropakar_sidebar_position;
		if ( ! is_active_sidebar( 'sidebar-1' ) || 'null' === $paropakar_sidebar_position || empty( $paropakar_sidebar_position ) ) :
			?>
			<div id="main-col" class="col-lg-12 search-col">
		<?php else : ?>
			<div id="main-col" class="col-lg-8 search-col">
		<?php endif; ?>
			<div id="main" class="site-main">

				<?php
				if ( have_posts() ) :
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/post/content', 'excerpt' );

					endwhile; // End of the loop.

					the_posts_pagination(
						array(
							'prev_text'          => '<span class="screen-reader-text">' . __( 'Previous page', 'paropakar' ) . '</span>',
							'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'paropakar' ) . '</span>',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'paropakar' ) . ' </span>',
						)
					);

				else :
					?>

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'paropakar' ); ?></p>
					<?php
						get_search_form();

				endif;
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
