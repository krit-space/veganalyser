<?php

$zadotPostsPagesArray = array(
	'select' => __('Select a post/page', 'zadot'),
);

$zadotPostsPagesArgs = array(
	
	// Change these category SLUGS to suit your use.
	'ignore_sticky_posts' => 1,
	'post_type' => array('post', 'page'),
	'orderby' => 'date',
	'posts_per_page' => -1,
	'post_status' => 'publish',
	
);
$zadotPostsPagesQuery = new WP_Query( $zadotPostsPagesArgs );
	
if ( $zadotPostsPagesQuery->have_posts() ) :
							
	while ( $zadotPostsPagesQuery->have_posts() ) : $zadotPostsPagesQuery->the_post();
			
		$zadotPostsPagesId = get_the_ID();
		if(get_the_title() != ''){
				$zadotPostsPagesTitle = get_the_title();
		}else{
				$zadotPostsPagesTitle = get_the_ID();
		}
		$zadotPostsPagesArray[$zadotPostsPagesId] = $zadotPostsPagesTitle;
	   
	endwhile; wp_reset_postdata();
							
endif;

$zadotYesNo = array(
	'select' => __('Select', 'zadot'),
	'yes' => __('Yes', 'zadot'),
	'no' => __('No', 'zadot'),
);

$zadotSliderType = array(
	'select' => __('Select', 'zadot'),
	'header' => __('WP Custom Header', 'zadot'),
	'owl' => __('Owl Slider', 'zadot'),
);

$zadotServiceLayouts = array(
	'select' => __('Select', 'zadot'),
	'one' => __('One', 'zadot'),
	'two' => __('Two', 'zadot'),
);

$zadotAvailableCats = array( 'select' => __('Select', 'zadot') );

$zadot_categories_raw = get_categories( array( 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0, ) );

foreach( $zadot_categories_raw as $zadot_categoryy ){
	
	$zadotAvailableCats[$zadot_categoryy->term_id] = $zadot_categoryy->name;
	
}

$zadotBusinessLayoutType = array( 
	'select' => __('Select', 'zadot'), 
	'one' => __('One', 'zadot'),
	'woo-one' => __('Woocommerce One', 'zadot'),
);
