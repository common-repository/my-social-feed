(function($){

	"use strict";

	var $window = $(window);

  $window.on('load', function(){

    // container      
     $('.kp_instagram_container').each(function(){
      	var $insta = $(this);
		    var $insta_options = ( $insta.attr('data-insta-options')) ? $insta.data('insta-options') : {};				
      	$.instagramFeed($insta_options);
    });

  });

})(jQuery);