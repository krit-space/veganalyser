<div class="wooOneContainer">

	<div class="wooOneWelcomeContainer">
		
			<?php
			
				$zadotWelcomePostTitle = '';
				$zadotWelcomePostDesc = '';

				if( '' != get_theme_mod('zadot_wooone_welcome_post') && 'select' != get_theme_mod('zadot_wooone_welcome_post') ){

					$zadotWelcomePostId = get_theme_mod('zadot_wooone_welcome_post');

					if( ctype_alnum($zadotWelcomePostId) ){

						$zadotWelcomePost = get_post( $zadotWelcomePostId );

						$zadotWelcomePostTitle = $zadotWelcomePost->post_title;
						$zadotWelcomePostDesc = $zadotWelcomePost->post_excerpt;
						$zadotWelcomePostContent = $zadotWelcomePost->post_content;

					}

				}			
			
			?>
			
			<h1><?php echo esc_html($zadotWelcomePostTitle); ?></h1>
			<div class="wooOneWelcomeContent">
				<p>
					<?php 
					
						if( '' != $zadotWelcomePostDesc ){
							
							echo esc_html($zadotWelcomePostDesc);
							
						}else{
							
							echo esc_html($zadotWelcomePostContent);
							
						}
					
					?>
				</p>
			</div><!-- .wooOneWelcomeContent -->	
		
	</div><!-- .wooOneWelcomeContainer -->
	
	
	<div class="new-arrivals-container">
		
		<?php 
					
			if( 'no' != get_theme_mod('zadot_show_wooone_heading') ): 
			
				$zadotWooOneLatestHeading = __('Latest Products', 'zadot');	
				$zadotWooOneLatestText = __('Some of our latest products', 'zadot');
			
					
				if( '' != get_theme_mod('zadot_wooone_latest_heading') ){
					$zadotWooOneLatestHeading = get_theme_mod('zadot_wooone_latest_heading');
				}
				
				if( '' != get_theme_mod('zadot_wooone_latest_text') ){
					$zadotWooOneLatestText = get_theme_mod('zadot_wooone_latest_text');
				}				
			
					
		?>
		<div class="new-arrivals-title">
		
			<h3><?php echo esc_html($zadotWooOneLatestHeading); ?></h3>
			<p><?php echo esc_html($zadotWooOneLatestText); ?></p>
		
		</div><!-- .new-arrivals-title -->
		<?php endif; ?>
		
		<?php
			
			$zadotWooOnePaged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
			
			$zadot_front_page_ecom = array(
				'post_type' => 'product',
				'paged' => $zadotWooOnePaged
			);
			$zadot_front_page_ecom_the_query = new WP_Query( $zadot_front_page_ecom );
			
			$zadot_front_page_temp_query = $wp_query;
			$wp_query   = NULL;
			$wp_query   = $zadot_front_page_ecom_the_query;
			
		?>		
		
		<div class="new-arrivals-content">
		<?php if ( have_posts() && post_type_exists('product') ) : ?>
		
		
			<div class="zadot-woocommerce-content">
			
				<ul class="products">
			
					<?php /* Start the Loop */ ?>
					<?php while ( $zadot_front_page_ecom_the_query->have_posts() ) : $zadot_front_page_ecom_the_query->the_post(); ?>			
					<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
				
				</ul><!-- .products -->
				
				<?php //the_posts_navigation(); ?>
				
				<?php zadot_pagination( $zadotWooOnePaged, $zadot_front_page_ecom_the_query->max_num_pages); // Pagination Function ?>
				
			</div><!-- .zadot-woocommerce-content -->
			
		<?php else : ?>
		
			<p><?php echo __('Please install wooCommerce and add products.', 'zadot') ?></p>

		<?php 
			
			endif; 
			wp_reset_postdata();
			$wp_query = NULL;
			$wp_query = $zadot_front_page_temp_query;
		?>			
		
		
		</div><!-- .new-arrivals-content -->		
	
	</div><!-- .new-arrivals-container -->	

</div>