;(function ($) {
	
	"use strict";
	
	$(document).ready(function () {
		$('.shortcode-product').each(function () {
			let $shortcode = $(this);
			let $elSlick = $shortcode.find('.s-product-carousel');
			
			$elSlick.on('init', function (event, slick) {
				setTimeout(function () {
					$elSlick.css({'visibility': 'visible'});
					$elSlick.off('init');
				}, 50);
				
			});
			
			$elSlick.slick({
				variableWidth: false,
				dots: true,
				infinite: true,
				//adaptiveHeight: true,
				cssEase: 'linear',
				slidesToShow: 2,
				lazyLoad: 'ondemand',
				autoplay: $elSlick.data('autoplay') !== 'off',
				autoplaySpeed: $elSlick.data('autoplay-speed') || 3000,
				centerMode: false,
				focusOnSelect: true,
				responsive: [
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 1
						}
					}
				]
				
			});
			
		});
	});
	
	
})(window.jQuery);