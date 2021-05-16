<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div id="main" class="site-main" role="main" style=" margin: 45px 0;">

				<section class="error-404 not-found">
					<header class="page-heading">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'paropakar' ); ?></h1>
					</header><!-- .page-header -->
					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'paropakar' ); ?></p>

						<?php get_search_form(); ?>

					</div><!-- .page-content -->
				</section><!-- .error-404 -->
			</div><!-- #main -->
		</div><!-- .col-md-8 -->
	</div><!-- .row -->
</div>

<?php
get_footer();
