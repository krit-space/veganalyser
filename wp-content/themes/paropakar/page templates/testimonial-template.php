<?php
/*
Template Name: Client Testimonial
*/
?>

<?php get_header() ; ?>
<div id="testimonial">
    <section class="testimonial">
        <div class="container">
            <?php while( have_posts()) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <h3><?php the_excerpt(); ?></h3>
            <?php endwhile; ?>
            <div class="row">
	            <?php
	            for( $paropakar_count = 1; $paropakar_count<=6; $paropakar_count++ ){
		            $paropakar_page = intval( get_theme_mod( 'paropakar_testimonial_setting_'.$paropakar_count) );
		            if ( 'page-none-selected' != $paropakar_page ) {
			            $paropakar_pages[] = $paropakar_page;
		            }
	            }
	            if( !empty($paropakar_pages) ){
		            $paropakar_page_query = new WP_Query( array(
			            'post_type' => 'page',
			            'post__in' => $paropakar_pages,
		            ));
	            }

	            ?>
                <?php while( $paropakar_page_query->have_posts() ) : $paropakar_page_query->the_post(); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="testimonial-content">
                            <img class="testimonial-image" src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php the_title(); ?>" >
                            <p><?php the_content(); ?></p>
                            <span><?php the_title(); ?></span>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_query(); ?>
            </div>
        </div>
    </section>
</div>

<?php get_footer() ; ?>