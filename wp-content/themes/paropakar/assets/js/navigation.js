/**
*
*	Menu Item Children Drop-Down
*
**/

jQuery(function($){

	if ( $(window).width() < 991) {      
		var mobileItems = $( 'nav.main-navigation div.navbar-collapse' );
	 	mobileItems.find( 'li.menu-item-has-children' ).append( '<i class="mobile-arrows fa fa-chevron-down"></i>' );

		jQuery("i.mobile-arrows").click(function() {
			if( jQuery( this ).hasClass( "fa-chevron-down" ) )
				jQuery( this ).removeClass( "fa-chevron-down" ).addClass( "fa-chevron-up" );
			else
				jQuery( this ).removeClass( "fa-chevron-up" ).addClass( "fa-chevron-down" );

			jQuery( this ).parent().find('ul:first').toggle();
		});
	}

});



/**
*
*	To The Top
*
**/

jQuery(document).ready(function($){
    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
            $('#up-btn').fadeIn('fast');
        } else {
            $('#up-btn').fadeOut('medium');
        }
    });
    $('#up-btn').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 1800);
        return false;
    });
});


/**
*
*	Second Navigation Bar
*
**/

(function ($) {
    $(document).ready(function(){
		const mq = window.matchMedia( "(min-width: 375px)" );

	    $(".fixed-top").hide();

	    $(function () {
	        $(window).scroll(function () {
	            if (mq.matches) {
	              if ($(this).scrollTop() > 200) {
	                  $('.fixed-top').fadeIn();
	              } else {
	                  $('.fixed-top').fadeOut();
	              }
	            } else {
	              if ($(this).scrollTop() > 300) {
	                  $('.fixed-top').fadeIn();
	              } else {
	                  $('.fixed-top').fadeOut();
	              }
	            }
	          });
	      });

	  });
    }(jQuery));