    <div class="site-slider zadot-owl-basic">

        <div id="zadot-owl-basic" class="owl-carousel owl-theme">
    
    		<?php 
			
				if(get_theme_mod('zadot_slider_num')){
					$zadot_slider_num = get_theme_mod('zadot_slider_num');
				}else{
					$zadot_slider_num = '5';
				}
			
				if(get_theme_mod('zadot_slider_cat')){
					$zadot_slider_cat = get_theme_mod('zadot_slider_cat');
				}else{
					$zadot_slider_cat = 0;
				}			
			
				$zadot_slider_args = array(
                    // Change these category SLUGS to suit your use.
                    'ignore_sticky_posts' => 1,
                    'post_type' => array('post'),
                    'posts_per_page'=> $zadot_slider_num,
					'cat' => $zadot_slider_cat
               );
        
			   $zadot_slider = new WP_Query($zadot_slider_args);
			
            if ( $zadot_slider->have_posts() ) : ?>            
			<?php /* Start the Loop */ ?>
			<?php while ( $zadot_slider->have_posts() ) : $zadot_slider->the_post(); ?>
            <div class="owl-carousel-slide">
                
                <?php if ( has_post_thumbnail()) : ?>	
                <?php the_post_thumbnail('zadot-owl'); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/2000.png">
                <?php endif; ?>
                
                <div class="owl-carousel-caption-container">
                    <h3>
						<a href="<?php the_permalink() ?>">
						<?php the_title(); ?>
                        </a>
                    </h3>
                    <div class="owl-carousel-caption">
						<p><?php echo esc_html(zadot_limitedstring(get_the_excerpt())); ?></p>
						<p><a href="<?php the_permalink() ?>"><?php echo __( 'Read More', 'zadot' ); ?></a></p>
					</div>
                </div>
                 	
            </div>
    		<?php endwhile; wp_reset_postdata(); endif; ?>
            
         </div>
    
    </div><!-- .site-slider --> 