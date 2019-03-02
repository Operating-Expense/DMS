;(function ($) {
	
	"use strict";
	
	$(document).ready(function () {
		$('.shortcode-image_slider').each(function () {
			let $shortcode = $(this);
			let $elSlick = $shortcode.find('.s-is-carousel');
			
			$elSlick.on('init', function (event, slick) {
				setTimeout(function () {
					$elSlick.css({'visibility': 'visible'});
					$elSlick.off('init');
				}, 50);
				
			});
			
			$elSlick.slick({
				variableWidth: true,
				dots: false,
				infinite: true,
				//adaptiveHeight: true,
				cssEase: 'linear',
				slidesToShow: $elSlick.data('num') || 3,
				lazyLoad: 'ondemand',
				autoplay: $elSlick.data('autoplay') !== 'off',
				autoplaySpeed: $elSlick.data('autoplay-speed') || 3000,
				centerMode: true,
				focusOnSelect: true,
				responsive: [
					{
						breakpoint: 992,
						settings: {
							slidesToShow: $elSlick.data('num-medium') || 2
						}
					},
					{
						breakpoint: 576,
						settings: {
							slidesToShow: $elSlick.data('num-small') || 1
						}
					}
				]
				
			});
			
		});
	});
	
	
})(window.jQuery);