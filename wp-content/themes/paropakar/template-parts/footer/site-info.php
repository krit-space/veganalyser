<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

?>
	<?php if ( get_theme_mod( 'paropakar_show_footer_copyright' ) === '1' ) : ?>
		<p>&copy; <?php echo esc_attr__( '2018', 'paropakar' ); ?> <span><a href="<?php echo esc_url( __( 'http://www.themesmandu.com/', 'paropakar' ) ); ?>" target="_blank"><?php echo esc_attr__( 'ThemesMandu.com', 'paropakar' ); ?></a> </span> <?php echo esc_attr__( 'All Rights Reserved.', 'paropakar' ); ?></p>
	<?php endif; ?>
