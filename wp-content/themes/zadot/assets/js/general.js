// JavaScript Document
jQuery(document).ready(function() {
	
	var zadotViewPortWidth = '',
		zadotViewPortHeight = '';

	function zadotViewport(){

		zadotViewPortWidth = jQuery(window).width(),
		zadotViewPortHeight = jQuery(window).outerHeight(true);	
		
		if( zadotViewPortWidth > 1200 ){
			
			jQuery('.main-navigation').removeAttr('style');
			
			var zadotSiteHeaderHeight = jQuery('.site-header').outerHeight();
			var zadotSiteHeaderWidth = jQuery('.site-header').width();
			var zadotSiteHeaderPadding = ( zadotSiteHeaderWidth * 2 )/100;
			var zadotMenuHeight = jQuery('.menu-container').height();
			
			var zadotMenuButtonsHeight = jQuery('.site-buttons').height();
			
			var zadotMenuPadding = ( zadotSiteHeaderHeight - ( (zadotSiteHeaderPadding * 2) + zadotMenuHeight ) )/2;
			var zadotMenuButtonsPadding = ( zadotSiteHeaderHeight - ( (zadotSiteHeaderPadding * 2) + zadotMenuButtonsHeight ) )/2;
		
			
			jQuery('.menu-container').css({'padding-top':zadotMenuPadding});
			jQuery('.site-buttons').css({'padding-top':zadotMenuButtonsPadding});
			
			
		}else{

			jQuery('.menu-container, .site-buttons, .header-container-overlay, .site-header').removeAttr('style');

		}	
	
	}

	jQuery(window).on("resize",function(){
		
		zadotViewport();
		
	});
	
	zadotViewport();


	jQuery('.site-branding .menu-button').on('click', function(){
				
		if( zadotViewPortWidth > 1200 ){

		}else{
			jQuery('.main-navigation').slideToggle();
		}				
		
				
	});	

    var owl = jQuery("#zadot-owl-basic");
         
    owl.owlCarousel({
             
      	slideSpeed : 300,
      	paginationSpeed : 400,
      	singleItem:true,
		navigation : true,
      	pagination : false,
      	navigationText : false,
         
    });			
	
});		