<div class="zadotOneContainer">
	
	<?php if( '' != get_theme_mod('zadot_four_welcome_post') && 'select' != get_theme_mod('zadot_four_welcome_post') ) : 

			$zadotOneWelcomePostTitle = '';
			$zadotOneWelcomePostDesc = '';
			$zadotOneWelcomePostContent = '';


			$zadotOneWelcomePostId = get_theme_mod('zadot_four_welcome_post');

			if( ctype_alnum($zadotOneWelcomePostId) ){

				$zadotOneWelcomePost = get_post( $zadotOneWelcomePostId );

				$zadotOneWelcomePostTitle = $zadotOneWelcomePost->post_title;
				$zadotOneWelcomePostDesc = $zadotOneWelcomePost->post_excerpt;
				$zadotOneWelcomePostContent = $zadotOneWelcomePost->post_content;

			}			

	?>

	<div class="zadotOneWelcome">

		<h2><?php echo esc_html($zadotOneWelcomePostTitle); ?></h2>
		<p>
		<?php 

			if( '' != $zadotOneWelcomePostDesc ){

				echo esc_html($zadotOneWelcomePostDesc);

			}else{

				echo esc_html($zadotOneWelcomePostContent);

			}

		?>			
		</p>

	</div>	
	
	<?php endif; ?>
	
	<?php
		if( '' != get_theme_mod('zadot_four_services_cat') && 'select' != get_theme_mod('zadot_four_services_cat') ):
	?>
	<div class="zadotFouServices">
		
		<?php

			$zadot_four_cat = '';

			if(get_theme_mod('zadot_four_services_cat')){
					$zadot_four_cat = get_theme_mod('zadot_four_services_cat');
			}else{
					$zadot_four_cat = 0;
			}
		
			if(get_theme_mod('zadot_four_services_num')){
					$zadot_four_cat_num = get_theme_mod('zadot_four_services_num');
			}else{
					$zadot_four_cat_num = 4;
			}		

			$zadot_four_args = array(
				   // Change these category SLUGS to suit your use.
				   'ignore_sticky_posts' => 1,
				   'post_type' => array('post'),
				   'posts_per_page'=> $zadot_four_cat_num,
				   'cat' => $zadot_four_cat
			);

			$zadot_four = new WP_Query($zadot_four_args);		

			if ( $zadot_four->have_posts() ) : while ( $zadot_four->have_posts() ) : $zadot_four->the_post();
		
   		?>		
	
		<div class="zadotFouServicesItem">
			
			<div class="zadotFouServicesItemImage">
			
				<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail('zadot-home-posts');
						}else{
							echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/frontsix.png" />';
						}						
				?>
				
			</div>
			
			<div class="zadotFouServicesItemContent">
			
				<?php the_title( '<h2><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
				<p>
					<?php  
						
						//$frontPostExcerpt = '';
						//$frontPostExcerpt = get_the_excerpt();
					
						if( has_excerpt() ){
							echo esc_html(get_the_excerpt());
						}else{
							echo esc_html(zadot_limitedstring(get_the_content(), 50));
						}
					
					?>
				</p>
				
			</div>			
			
		</div>
		<?php endwhile; wp_reset_postdata(); endif;?>
		
	</div>
	<?php endif; ?>
	
</div>