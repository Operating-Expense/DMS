;(function ($) {
	
	"use strict";
	
	$(document).ready(function () {
		$('.shortcode-image_slider').each(function () {
			let $shortcode = $(this);
			
			$shortcode.on('init', function (event, slick) {
				setTimeout(function () {
					$shortcode.css({'visibility': 'visible'});
					$shortcode.off('init');
				}, 50);
				
			});
			
			$shortcode.slick({
				variableWidth: true,
				dots: false,
				infinite: true,
				//adaptiveHeight: true,
				cssEase: 'linear',
				slidesToShow: $shortcode.data('num') || 3,
				lazyLoad: 'ondemand',
				autoplay: $shortcode.data('autoplay') !== 'off',
				autoplaySpeed: $shortcode.data('autoplay-speed') || 3000,
				centerMode: true,
				focusOnSelect: true,
				responsive: [
					{
						breakpoint: 992,
						settings: {
							slidesToShow: $shortcode.data('num-medium') || 2
						}
					},
					{
						breakpoint: 576,
						settings: {
							slidesToShow: $shortcode.data('num-small') || 1
						}
					}
				]
				
			});
			
		});
	});
	
	
})(window.jQuery);