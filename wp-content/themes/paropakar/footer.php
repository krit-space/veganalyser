<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

?>
		</div><!-- #content -->

		<div id="pr_slick_slider">
			<div class="container">
				<?php
				$paropakar_client_logo = paropakar_get_pages( 'paropakar_client_logo_setting_' );
				if ( ! empty( $paropakar_client_logo ) ) :
					$paropakar_page_query = new WP_Query(
						array(
							'post_type' => 'page',
							'post__in'  => $paropakar_client_logo,
						)
					);
					?>
					<div class="footer-slider">
						<h2><?php echo esc_html_e( 'Our Partners', 'paropakar' ); ?></h2>
						<section class="slick-slider slider">
							<?php
							while ( $paropakar_page_query->have_posts() ) :
								$paropakar_page_query->the_post();
								?>
								<div class="slide">
									<img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" alt="<?php the_title(); ?>">
								</div>
							<?php endwhile; ?>
						</section>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-5' ) ) { ?>
			<div id="footer">
				<div class="container">
					<div class="row">

						<div class="col-lg-4 social-media">

							<?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
								<div class="widget-column footer-widget-1">
									<?php dynamic_sidebar( 'sidebar-2' ); ?>
								</div>
							<?php } ?>

						</div>

						<div class="col-lg-4 footer-menu">

							<?php if ( is_active_sidebar( 'sidebar-3' ) ) { ?>
								<div class="widget-column footer-widget-2">
									<?php dynamic_sidebar( 'sidebar-3' ); ?>
								</div>
							<?php } ?>

						</div>

						<div class="col-lg-4 social-media">

							<?php if ( is_active_sidebar( 'sidebar-5' ) ) { ?>
								<div class="widget-column footer-widget-3">
									<?php dynamic_sidebar( 'sidebar-5' ); ?>
								</div>
							<?php } ?>

						</div>
					</div>
				</div><!-- .container -->
			</div><!-- #footer -->

		<?php } ?>

		<div class="last-footer">
			<div class="container">
				<?php
				get_template_part( 'template-parts/footer/site', 'info' );

				if ( get_theme_mod( 'paropakar_to_the_top' ) === '1' ) :
					?>
					<button id="up-btn" title="Go to top" style="display: block;">&uarr;</button>
					<?php endif; ?>

			</div>
		</div>

		<?php wp_footer(); ?>

	</body>
</html>
