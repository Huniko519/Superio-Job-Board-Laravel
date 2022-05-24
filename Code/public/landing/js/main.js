jQuery(document).ready(function($){
	$('.menu li a').click(function(){
		var target = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(target).offset().top - 83
        }, 1000);
        return false;
    });
	var height_header = $('.apus-header').height();
	if(height_header > 1){
		 $(".topheader").css("padding-top", height_header); 
	}
	$(window).scroll(function() {
	  if( $(this).scrollTop() > height_header ) {
	    $('.apus-header').addClass('stick');
	  } else {
	    $('.apus-header').removeClass('stick');
	  }
	});
});