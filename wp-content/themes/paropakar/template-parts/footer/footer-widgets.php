<?php
/**
 * Displays footer widgets if assigned
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

?>

<?php
if ( is_active_sidebar( 'sidebar-2' ) ) :
	?>
	<div class="container">

		<div class="footer-widget row" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'paropakar' ); ?>">
				<?php
				if ( is_active_sidebar( 'sidebar-2' ) ) {
					?>
					<div class="widget-column footer-widget-1 col-lg-4 col-md-6">
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
					</div>
					<div class="col-lg-2 col-md-2">
					</div>
				<?php } ?>
		</div>

	</div><!-- .container -->

<?php endif; ?>
