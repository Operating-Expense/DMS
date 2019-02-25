(function ($) {

	"use strict";

	window.DMS_tabs_shortcode = function () {

		// build tabs markup
		$('.dms_tabs').each(function () {

			var $shortcode = $(this),
				$titles = $shortcode.find('h4'),
				$tabs = $shortcode.find('.dms_tabs_tab'),
				type = $shortcode.data('type'),
				respBreak = $shortcode.data('break');

			// build nav for tabs
			$shortcode.prepend('<nav></nav>');

			var $nav = $shortcode.find('nav');

			$titles.each(function () {

				$nav.append('<a href="javascript:;">' + $(this).html() + '</a>');

			});

			$nav.find('a:first').addClass('current');
			$shortcode.find('.dms_tabs_tab:first').addClass('current active');

			// turn tabs into accordion on responsive break
			if ($shortcode.hasClass('type-accordion') == false) {

				$(window).on('resize', function () {

					if ($(window).width() <= respBreak) {
						$shortcode.removeClass('type-vertical');
						$shortcode.removeClass('type-default');
						$shortcode.addClass('type-accordion');
						$shortcode.find('.dms_tabs_tab').show();
						$shortcode.find('.dms-tab-content').hide();
						$shortcode.find('.dms_tabs_tab:first .dms-tab-content').show();
						$shortcode.find('.dms_tabs_tab').removeClass('current').removeClass('active');
						$shortcode.find('.dms_tabs_tab:first').addClass('current').addClass('active');
					} else {
						$shortcode.find('.dms-tab-content').show();

						$shortcode.find('.dms_tabs_tab').hide().removeClass('current');
						$shortcode.find('.dms_tabs_tab:first').show().addClass('current');

						$nav.find('a').removeClass('current').removeClass('active');
						$nav.find('a:first').addClass('current active');

						$shortcode.removeClass('type-accordion');
						$shortcode.addClass('type-' + type);
					}

				});

				$(window).trigger('resize');

			}

		});

	}

	window.DMS_tabs_nav_shortcode = function () {

		// tabs click
		$('.dms_tabs.type-default nav a, .dms_tabs.type-vertical nav a').off('click').on('click', function () {

			var $link = $(this),
				$shortcode = $link.parents('.dms_tabs'),
				index = $link.parent().find('a').index($link);

			$shortcode.find('.dms_tabs_tab').hide();
			$shortcode.find('.dms_tabs_tab').eq(index).show();

			$shortcode.find('nav a').removeClass('current');
			$link.addClass('current');

			return false;
		});

		// accordion click
		$('.dms_tabs.type-accordion .dms-title').off('click').on('click', function () {

			var $link = $(this),
				$block = $link.parents('.dms_tabs_tab');

			$link.parents('.dms_tabs_tab').toggleClass('active');

			$block.find('.dms-tab-content').slideToggle();

			return false;
		});

	}

	window.DMS_tabs_shortcode();

	window.DMS_tabs_nav_shortcode();

	$(window).on('resize', function () {
		window.DMS_tabs_nav_shortcode();
	});

})(window.jQuery);
