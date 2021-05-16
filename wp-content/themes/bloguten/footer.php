<?php
/**
 * The template for displaying the footer
 * Contains the closing of the body tag and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since Bloguten 1.0.0
 */
?>
	</div> <!-- site main end -->
	<?php 
		/**
		* Prints Instagram
		* 
		* @since Bloguten 1.0.0
		*/
		if( bloguten_get_option( 'enable_instagram' ) ){
			echo do_shortcode( bloguten_get_option( 'insta_shortcode' ) );
		}
	?>
	
	<?php
	$footer_layout_class = '';
	if( bloguten_get_option( 'footer_layout' ) == 'footer_one' ){
		$footer_layout_class = 'site-footer-primary';
	}
	?>
	<footer id="colophon" class="site-footer <?php echo esc_attr( $footer_layout_class ); ?>">
		<?php get_template_part('template-parts/footer/top', 'footer'); ?>
		<div class="bottom-footer">
			<?php if( bloguten_get_option( 'footer_layout' ) == 'footer_one' ): ?>
				<div class="container">
					<?php if( has_nav_menu( 'social' )): ?>
						<div class="socialgroup">
							<?php echo bloguten_get_menu( 'social' ); ?>
						</div>
					<?php endif; ?>
					<div class="desc-menu-wrap">
						<?php get_template_part('template-parts/footer/site', 'info'); ?>
						<?php if ( has_nav_menu( 'footer' ) ): ?>
							<div class="footer-menu">
								<?php echo bloguten_get_menu( 'footer' ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</footer>
	<?php wp_footer(); ?>
	</body>
</html>