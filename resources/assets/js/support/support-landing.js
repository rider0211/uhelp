(function($) {
    "use strict";

    // ______________Testimonial-owl-carousel2
    var owl = $('.testimonial-owl-carousel');
	owl.owlCarousel({
		loop: true,
		rewind: false,
		margin: 25,
		autoplay: true,
		lazyLoad: true,
		dots: false,
		nav: true,
		responsiveClass: true,
		responsive: {
			0: {
				items: 1,
				nav: true
			}
		}
	})
	owlRtl()

	// ______________Accoradation
		$("#accordion").on('click', function () {
			$('.acc-header').toggleClass('active');
		});


})(jQuery);

 function owlRtl(){
	var carousel = $('.rtl .owl-carousel');
			$.each(carousel ,function( index, element)  {
			var carouselData = $(element).data('owl.carousel');
			carouselData.settings.rtl = true; //don't know if both are necessary
			carouselData.options.rtl = true;
			$(element).trigger('refresh.owl.carousel');
			});
}
 
 