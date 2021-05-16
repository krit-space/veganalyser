<?php
/**
 * Displays header layout one
 * @since Bloguten 1.0.0
 */
?>

<header id="masthead" class="wrapper site-header site-header-primary" role="banner">
	<?php if( display_header_text() || has_custom_logo() ): ?>
		<div class="main-header">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-4 d-none d-lg-block">
						<div class="header-icons-wrap text-left">
							<div class="socialgroup">
								<?php echo bloguten_get_menu( 'social' ); ?>
							</div>
						</div>
					</div>
					<div class="col-6 col-lg-4">
						<?php
							get_template_part( 'template-parts/header/site', 'branding' );
						?>
					</div>
					<div class="col-lg-4 col-6">
						<div class="header-icons-wrap text-right">
							<?php get_template_part('template-parts/header/header', 'search'); ?>
							<?php
								$hamburger_menu_class = '';
								if( bloguten_get_option( 'disable_hamburger_menu_icon' ) ){
									$hamburger_menu_class = 'd-inline-block d-lg-none';
								}
							?>
							<span class="alt-menu-icon <?php echo esc_attr( $hamburger_menu_class ); ?>">
								<a class="offcanvas-menu-toggler" href="#">
									<span class="icon-bar"></span>
								</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="main-navigation-wrap">
		<div class="container">
			<div class="wrap-nav main-navigation">
				<div id="navigation" class="d-none d-lg-block">
					<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'bloguten' ); ?>">
						<?php echo bloguten_get_menu( 'primary' ); ?>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- Search form structure -->
	<div class="header-search-wrap">
		<div id="search-form">
			<?php get_search_form(); ?>
		</div>
	</div>
</header>