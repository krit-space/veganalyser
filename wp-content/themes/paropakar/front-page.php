<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

get_header(); ?>
<?php
if ( get_theme_mod( 'paropakar_slider_activation' ) === '1' ) :
	$paropakar_slider_pages = paropakar_get_pages( 'paropakar_header_slider_' );
	if ( $paropakar_slider_pages ) :
		$paropakar_page_query = new WP_Query(
			array(
				'post_type' => 'page',
				'post__in'  => $paropakar_slider_pages,
			)
		);
		?>
		<div id="image-slider" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<?php
				$paropakar_count = 0;
				while ( $paropakar_page_query->have_posts() ) :
					$paropakar_page_query->the_post();
					?>
					<div class="carousel-item carousel-item-<?php echo esc_attr( $paropakar_count ); ?> <?php echo ( $paropakar_count === 0 ) ? 'active' : ''; ?>" >
						<div class="image_slider_image">
							<img src="<?php echo esc_url( get_the_post_thumbnail_url( null, 'paropakar-featured-image' ) ); ?>" alt="<?php the_title(); ?>" >
						</div>
						<div class="carousel-caption">
							<h3 class="heading-top"><?php the_title(); ?></h3> <br>
							<p><?php the_excerpt(); ?></p>
							<a href="<?php the_permalink(); ?>" target="_blank"><?php echo esc_attr__( 'Read More', 'paropakar' ); ?></a>
						</div>
					</div>
					<?php $paropakar_count++; ?>
					<?php
					endwhile;
				wp_reset_postdata();
				?>
			</div>
			<a class="carousel-control-prev" href="#image-slider" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="carousel-control-next" href="#image-slider" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
		</div>
	<?php endif; ?>
	<?php
elseif ( get_theme_mod( 'paropakar_header_img' ) ) :
	$paropakar_image_attributes = get_theme_mod( 'paropakar_header_img' );
	?>
	<div class="background">
		<img src="<?php echo esc_attr( $paropakar_image_attributes ); ?>" alt="header-image" >
	</div>
	<?php
endif;

/*
* Services Section
*/

$paropakar_services_mainpage = get_theme_mod( 'paropakar_services_page' );
?>
<section class="section-one">
	<div class="container">
		<?php
		if ( $paropakar_services_mainpage ) :
			$paropakar_page    = get_post( $paropakar_services_mainpage );
			$paropakar_title   = apply_filters( 'paropakar_the_title', $paropakar_page->post_title );
			$paropakar_content = apply_filters( 'paropakar_the_content', $paropakar_page->post_content );
			?>
			<h1><?php echo wp_kses_post( $paropakar_title ); ?></h1>
			<h2><?php echo wp_kses_post( $paropakar_content ); ?></h2>
			<?php
		endif;
		$paropakar_service_pages = paropakar_get_pages( 'paropakar_services_setting_' );
		if ( ! empty( $paropakar_service_pages ) ) :
			$paropakar_page_query = new WP_Query(
				array(
					'post_type' => 'page',
					'post__in'  => $paropakar_service_pages,
				)
			);
			?>
			<div class="row">
				<?php
				while ( $paropakar_page_query->have_posts() ) :
					$paropakar_page_query->the_post();
					?>
					<div class="col-md-4">
						<a>
							<?php if ( has_post_thumbnail() ) : ?>
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( null, 'paropakar-service-avatar' ) ); ?>" alt="<?php the_title(); ?>" />
							<?php endif; ?>
							<p><?php the_excerpt(); ?></p>
						</a>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
	</div>
	<?php endif; ?>
</section>

<?php

/*
* Cause Section
*/

if ( class_exists( 'Give' ) ) :
	?>
	<section class="section-two">
		<div class="container">
			<h1><?php echo esc_html__( 'Our Causes', 'paropakar' ); ?></h1>
			<h2><?php echo esc_html__( 'Your Little Help Means A Lot To Others', 'paropakar' ); ?></h2>
			<div class="row">
				<?php
				$paropakar_args       = array(
					'post_type'      => 'give_forms',
					'posts_per_page' => '3',
				);
				$paropakar_page_query = new WP_Query( $paropakar_args );
				while ( $paropakar_page_query->have_posts() ) :
					$paropakar_page_query->the_post();
					global $post;
					$paropakar_postid = $post->ID;
					?>
					<div class="col-md-4 column">
						<?php echo get_the_post_thumbnail(); ?>
						<a href="<?php esc_url( the_permalink() ); ?>"><h3><?php the_title(); ?></h3></a>
						<?php
						echo esc_attr( give_form_display_content( $paropakar_postid, $paropakar_args ) );
						echo esc_attr( give_show_goal_progress( $paropakar_postid, $paropakar_args ) );
						?>
						<a class="donate_link" href = "<?php echo esc_url( get_permalink( $paropakar_postid ) ); ?>" ><?php echo esc_attr__( 'Donate', 'paropakar' ); ?></a>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php
endif;

/*
* Donation Section
*/

$paropakar_donation_page = get_theme_mod( 'paropakar_donation_setting' );
if ( ! empty( $paropakar_donation_page ) ) :
	$paropakar_page_details         = get_post( $paropakar_donation_page );
	$paropakar_donation_title       = $paropakar_page_details->post_title;
	$paropakar_donation_description = apply_filters( 'paropakar_the_content', $paropakar_page_details->post_content );
	$paropakar_donationid           = $paropakar_page_details->ID;
	?>
	<section class="section-four">
		<div class="container">
			<div class="row">
				<div class="col-md-6"></div>
				<div class="col-md-6 col-second">
					<h1><?php echo wp_kses_post( $paropakar_donation_title ); ?></h1>
					<p><?php echo wp_kses_post( $paropakar_donation_description ); ?></p>
					<p><a href="<?php the_permalink( $paropakar_donationid ); ?>" class="btn" target="_blank"><?php echo esc_attr__( 'Donate', 'paropakar' ); ?></a></p>
				</div>
			</div>
		</div>
			<img src="<?php echo esc_url( get_the_post_thumbnail_url( $paropakar_donationid ) ); ?>" alt="<?php echo wp_kses_post( $paropakar_donation_title ); ?>" />
	</section>

	<?php
endif;

/*
* Blog Section
*/
?>
<section class="section-six">
	<div class="container">
		<h1><?php echo esc_attr__( 'Our blog', 'paropakar' ); ?></h1>
		<div class="row">
			<?php
			// Define our WP Query Parameters.
			$paropakar_args       = array(
				'post_type'      => 'post',
				'posts_per_page' => '2',
			);
			$paropakar_page_query = new WP_Query( $paropakar_args );
			// Start our WP Query.
			while ( $paropakar_page_query->have_posts() ) :
				$paropakar_page_query->the_post();
				?>
				<div class="col-lg-6">
					<a href="<?php esc_url( the_permalink() ); ?>"><?php echo get_the_post_thumbnail(); ?></a>
					<a class="blog-heading" href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
					<span class="post-date"><?php echo get_the_date(); ?></span>
					<span class="post-comments"><i class="fas fa-comment"></i><?php comments_popup_link( 'No comment yet', '1', '%' ); ?></span>
					<?php the_excerpt(); ?>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>

<?php
get_footer();
