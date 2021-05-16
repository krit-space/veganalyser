<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$str       = '';
$sellerurl = get_query_var( 'info' );

$user = get_users(
	array(
		'meta_key'   => 'shop_address',
		'meta_value' => $sellerurl,
	)
);

if ( ! empty( $user ) ) {
	foreach ( $user as $value ) {
		$sellerid = $value->ID;
	}

	if ( isset( $_REQUEST['str'] ) ) {
		$str = $_REQUEST['str'];
	}

	if ( is_user_logged_in() ) {
		$user_value = $sellerurl;
	}

	?>

	<div class="mp-profile-wrapper woocommerce">

		<?php
			require 'seller-profile-details-section.php';

			do_action( 'mkt_before_seller_collection' );
		?>

		<div class="mp-seller-recent-product">
			<h3><?php esc_html_e( 'Product from Seller', 'marketplace' ); ?></h3>
			<?php

			$paged = ( get_query_var( 'pagenum' ) ) ? get_query_var( 'pagenum' ) : 1;

			$query_args = array(
				'author'         => $sellerid,
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => get_option( 'posts_per_page' ),
				'paged'          => $paged,
			);

			$query_args = apply_filters( 'mp_seller_collection_product_args', $query_args );

			$products = new WP_Query( $query_args );

			if ( $products->have_posts() ) {
				do_action( 'marketplace_before_shop_loop', $products->max_num_pages );
				woocommerce_product_loop_start();
				while ( $products->have_posts() ) : $products->the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;
				woocommerce_product_loop_end();
				do_action( 'marketplace_after_shop_loop', $products->max_num_pages );
			} else {
				echo esc_html__( 'No product available !', 'marketplace' );
			}

			wp_reset_postdata();

			?>
		</div>

	</div>

	<?php

	do_action( 'mkt_after_seller_collection' );

	require 'mp-popup-login-form.php';
	?>

	<?php

} else {
	?>

	<h1><?php echo esc_html__( 'Oops! That page can’t be found.', 'marketplace' ); ?></h1>
	<p><?php echo esc_html__( 'Nothing was found at this location.', 'marketplace' ); ?></p>

<?php } ?>
