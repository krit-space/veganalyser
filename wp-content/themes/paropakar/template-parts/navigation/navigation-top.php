<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

?>

<nav class="navbar navbar-expand-lg top-navigation" id="top-nav">

	<div class="container">
		<?php
		if ( function_exists( 'the_custom_logo' ) ) :
			if ( has_custom_logo() ) :
				the_custom_logo();
			else :
				?>
				<a class="navbar-brand" href = '<?php echo esc_url( get_site_url() ); ?>' ><?php echo bloginfo( 'name' ); ?></a>
				<?php
			endif;
		endif;
		?>

		<div class="top-links">

			<section class="top-social-icons">

				<?php if ( get_theme_mod( 'paropakar_show_social_icons' ) === '1' ) : ?>
					<div class="social-icons">
						<?php
						$paropakar_facebook = get_theme_mod( 'paropakar_facebook' );
						if ( ! empty( $paropakar_facebook ) ) :
							?>
						<a href="<?php echo esc_url( get_theme_mod( 'paropakar_facebook' ) ) ? esc_url( get_theme_mod( 'paropakar_facebook' ) ) : '#'; ?>" target = "_blank"><i class="fab fa-facebook-f"></i></a>
						<?php endif; ?>
					<?php
						$paropakar_plus_google = get_theme_mod( 'paropakar_plus_google' );
					if ( ! empty( $paropakar_plus_google ) ) :
						?>
						<a href="<?php echo esc_url( get_theme_mod( 'paropakar_plus_google' ) ) ? esc_url( get_theme_mod( 'paropakar_plus_google' ) ) : '#'; ?>" target = "_blank"><i class="fab fa-google-plus-g"></i></a>
						<?php endif; ?>
					<?php
						$paropakar_linkedin = get_theme_mod( 'paropakar_linkedin' );
					if ( ! empty( $paropakar_linkedin ) ) :
						?>
						<a href="<?php echo esc_url( get_theme_mod( 'paropakar_linkedin' ) ) ? esc_url( get_theme_mod( 'paropakar_linkedin' ) ) : '#'; ?>" target = "_blank"><i class="fab fa-linkedin-in"></i></a>
						<?php endif; ?>
					<?php
						$paropakar_twitter = get_theme_mod( 'paropakar_twitter' );
					if ( ! empty( $paropakar_twitter ) ) :
						?>
						<a href="<?php echo esc_url( get_theme_mod( 'paropakar_twitter' ) ) ? esc_url( get_theme_mod( 'paropakar_twitter' ) ) : '#'; ?>" target = "_blank"><i class="fab fa-twitter"></i></a>
						<?php endif; ?>
					<?php
						$paropakar_instagram = get_theme_mod( 'paropakar_instagram' );
					if ( ! empty( $paropakar_instagram ) ) :
						?>
						<a href="<?php echo esc_url( get_theme_mod( 'paropakar_instagram' ) ) ? esc_url( get_theme_mod( 'paropakar_instagram' ) ) : '#'; ?>" target = "_blank"><i class="fab fa-instagram"></i></a>
						<?php endif; ?>
					<?php
						$paropakar_youtube = get_theme_mod( 'paropakar_youtube' );
					if ( ! empty( $paropakar_youtube ) ) :
						?>
						<a href="<?php echo esc_url( get_theme_mod( 'paropakar_youtube' ) ) ? esc_url( get_theme_mod( 'paropakar_youtube' ) ) : '#'; ?>" target = "_blank"><i class="fab fa-youtube"></i></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</section>

		</div>
	</div>

</nav>

<nav class="navbar navbar-expand-lg main-navigation menu-navigation" id="main-nav" aria-label="<?php esc_attr_e( 'Top Menu', 'paropakar' ); ?>">

	<div class="container">
		<button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span></span>
			<span></span>
			<span></span>
		</button>

		<div class="collapse navbar-collapse" id="collapsibleNavbar">

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'top',
					'menu_id'        => 'top-menu',
					'menu_class'     => 'menu navbar-nav',
				)
			);
			?>
		</div>

		<section class="top-social-buttons">
			<?php
			$paropakar_donation_btn_name = get_theme_mod( 'paropakar_donation_btn_name' );
			if ( ! empty( $paropakar_donation_btn_name ) ) :
				?>
				<a href="<?php echo esc_url( get_theme_mod( 'paropakar_donation_btn_link' ) ); ?>" class="donate"><?php echo esc_attr( get_theme_mod( 'paropakar_donation_btn_name' ) ); ?></a>
			<?php endif; ?>
			<?php
			$paropakar_volunteer_btn_name = get_theme_mod( 'paropakar_volunteer_btn_name' );
			if ( ! empty( $paropakar_volunteer_btn_name ) ) :
				?>
				<a href="<?php echo esc_url( get_theme_mod( 'paropakar_volunteer_btn_link' ) ); ?>" class="volunteer"><?php echo esc_attr( get_theme_mod( 'paropakar_volunteer_btn_name' ) ); ?></a>
			<?php endif; ?>
		</section>

	</div>

</nav>

<nav class="navbar navbar-expand-lg main-navigation menu-navigation fixed-top" id="sub-nav" aria-label="<?php esc_attr_e( 'Top Menu', 'paropakar' ); ?>">

	<div class="container">
		<button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#collapsible-Navbar">
			<span></span>
			<span></span>
			<span></span>
		</button>

		<div class="collapse navbar-collapse" id="collapsible-Navbar">

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'top',
					'menu_id'        => 'sub-menu',
					'menu_class'     => 'menu navbar-nav',
				)
			);
			?>
		</div>

		<section class="top-social-buttons">
			<?php
			$paropakar_donation_btn_name = get_theme_mod( 'paropakar_donation_btn_name' );
			if ( ! empty( $paropakar_donation_btn_name ) ) :
				?>
				<a href="<?php echo esc_url( get_theme_mod( 'paropakar_donation_btn_link' ) ); ?>" class="donate"><?php echo esc_attr( get_theme_mod( 'paropakar_donation_btn_name' ) ); ?></a>
			<?php endif; ?>
			<?php
			$paropakar_volunteer_btn_name = get_theme_mod( 'paropakar_volunteer_btn_name' );
			if ( ! empty( $paropakar_volunteer_btn_name ) ) :
				?>
				<a href="<?php echo esc_url( get_theme_mod( 'paropakar_volunteer_btn_link' ) ); ?>" class="volunteer"><?php echo esc_attr( get_theme_mod( 'paropakar_volunteer_btn_name' ) ); ?></a>
			<?php endif; ?>
		</section>
	</div>

</nav>
