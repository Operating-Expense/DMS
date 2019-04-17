import $ from 'jquery';
import dmsSearch from './dms/search.js';

export default class Theme {
	/**
	 Constructor
	 **/
	constructor() {
		this.build();
	}
	
	/**
	 Build page elements, plugins init
	 **/
	build() {
		this.setupHeader();
		this.loadGoogleFonts();
		this.mobileMenuListener('.navigation-menu');
		this.smoothScrollToAnchor();
		this.changeLinkToLocalized();
		this.dmsPopups();
		this.dmsApiSearch();
	}
	
	/**
	 * Setup Header
	 **/
	setupHeader() {
		
		// mobile menu toggles
		$('#mobile-menu-toggler').on('click', function () {
			
			$(this).toggleClass('is-active');
			$('#header ul.menu').toggleClass('open');
			
			return false;
		});
		
		// mobile sub-menu toggler
		$('#header .menu-item-has-children').append('<span class="mobile-submenu-toggler"></span>');
		
		$('.mobile-submenu-toggler').on('click', function () {
			$(this).toggleClass('open').prev('.sub-menu').toggleClass('open');
		});
		
	}
	
	/**
	 * Load Google Fonts
	 **/
	loadGoogleFonts() {
		WebFont.load({google: {families: ["Roboto:400,500", "Montserrat:400"]}});
	}
	
	/** Check for mobile device **/
	isMobile() {
		return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
	}
	
	stringToBoolean(string) {
		
		switch (string) {
			case "true":
			case "yes":
			case "1":
				return true;
			case "false":
			case "no":
			case "0":
			case null:
			case '':
				return false;
			default:
				return Boolean(string);
		}
	}
	
	/** Check email address **/
	isValidEmailAddress(emailAddress) {
		const pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	}
	
	/** Mobile menu **/
	mobileMenuListener(selector) {
		
		jQuery(function ($) {
			
			$(selector).parent().find('.mobile-menu li.menu-item-has-children').prepend('<span class="rh-arrow"></span>');
			
			$(selector).parent().find('.mobile-menu li.menu-item-has-children>.rh-arrow').on('click', function (e) {
				$(this).parent().find('> .sub-menu').slideToggle("slow");
				$(this).toggleClass('active');
				$(this).parent().find('> a').toggleClass('active');
			});
			
			$('.menu-button').on('click', function (e) {
				e.stopPropagation();
				if ($(this).hasClass('s-intro__menu_caller')) {
					e.preventDefault();
					$("html, body").animate({scrollTop: 0}, "slow");
				}
				
				e.preventDefault();
				
				$('.menu-button').toggleClass('active');
				
				var $menu = $('.main-nav-section');
				
				if ($(this).hasClass('active')) {
					$menu.show().animate({"right": "0"}, 500);
				} else {
					$menu.animate({"right": "-100%"}, 500, function () {
							$(this).parent().find('.main-nav-section').hide()
						}
					);
				}
			});
			
			
			$('#main-wrapper').on('click', function (e) {
				e.stopPropagation();
				
				var $menu = $('.main-nav-section');
				var $menu_btn = $('.menu-button');
				
				if ($menu_btn.hasClass('active')) {
					$menu_btn.removeClass('active');
					$menu.show().animate({"right": "-100%"}, 500, function () {
							$(this).parent().find('.main-nav-section').hide()
						}
					);
				}
				
			});
			
			$('.main-nav-section').on('click', function (e) {
				e.stopPropagation();
			});
			
		});
		
	}
	
	
	smoothScrollToAnchor() {
		let $root = $('html, body');
		
		$('a[href^="#"], a[href^="/#"]').not('[href="#"]').on('click', function (event) {
			let href = $.attr(this, 'href');
			let hrefHashOnly = href.replace(/^\//, '');
			
			// Figure out element to scroll to
			let target = $(hrefHashOnly);
			
			// Does a scroll target exist?
			if (target.length) {
				// Only prevent default if animation is actually gonna happen
				event.preventDefault();
				$root.animate({
					scrollTop: $(hrefHashOnly).offset().top
				}, 700, function () {
					window.location.hash = hrefHashOnly;
				});
			}
			
		});
	}
	
	
	changeLinkToLocalized() {
		
		$('a[href^="/#"]').on('click', function (event) {
			let href = $.attr(this, 'href');
			let hrefHashOnly = href.replace(/^\//, '');
			
			// Figure out element to
			let target = $(hrefHashOnly);
			
			// Does a target not exist? -> go to another page
			if (!target.length && window.WPGlobus) {
				event.preventDefault();
				
				let langPart = window.WPGlobus.enabledLanguages[0] === window.WPGlobus.language ? '' : window.WPGlobus.language + '/';
				
				window.location.href = window.location.protocol + '//'
					+ window.location.hostname
					+ (location.port ? ":" + location.port : "")
					+ '/' + langPart
					+ hrefHashOnly;
			}
			
		});
	}
	
	
	// AVA
	
	readURL(input, img) {
		if (input.files && input.files[0]) {
			let reader = new FileReader();
			reader.onload = function (e) {
				$(img).removeAttr('srcset');
				$(img).attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	
	// --------------------------------------------------------------------
	//    POPUPS 
	// --------------------------------------------------------------------
	
	dmsPopups() {
		this.dmsPopupClose();
		this.dmsPopupTrigger('.js-dms-account', '#dms-login-popup-overlay');
		this.dmsPopupTrigger('.js-dms-account-forgot-trigger', '#dms-forgot-popup-overlay');
		this.dmsPopupTrigger('.js-dms-account-reg-trigger', '#dms-reg-popup-overlay');
		this.dmsLogin('#dms-login-popup-overlay');
		this.dmsRegistration('#dms-reg-popup-overlay');
		this.dmsForgot('#dms-forgot-popup-overlay');
	}
	
	dmsPopupTrigger(selectorTrigger, selectorPopup) {
		let $trigger = $(selectorTrigger);
		let $anyPopupWrapper = $('.dms-popup-overlay');
		let $popupWrapper = $(selectorPopup);
		
		$trigger.on('click', function (e) {
			e.preventDefault();
			$anyPopupWrapper.hide();
			$anyPopupWrapper.find('.error-box').html('');
			$popupWrapper.show();
		});
	}
	
	dmsPopupClose() {
		let $overlay = $('.dms-popup-overlay');
		let $close = $overlay.find('.dms-popup-close');
		
		$close.on('click', function (e) {
			e.preventDefault();
			$overlay.hide();
		});
	}
	
	// --------------------------------------------------------------------
	//    Account 
	// --------------------------------------------------------------------
	dmsAccountAjaxHandler(form, action, errorBox) {
		
		if (!form.length || !action.length || !errorBox.length) {
			return;
		}
		
		form.off('submit');
		form.on('submit', function (e) {
			e.preventDefault();
			
			$.ajax({
				type: "POST",
				url: themeJsVars.ajaxurl,
				data: {
					action: action,
					ajax_nonce: window.themeJsVars.ajax_nonce,
					form_data: form.serialize(),
				},
				beforeSend: function () {
					errorBox.html('');
				},
				success: function (response) {
					//console.log('response>>', response);
					if (response.success && response.data && response.data.redirect) {
						window.location.href = response.data.redirect;
					} else if (response.data) {
						errorBox.html(response.data.error_html);
					}
				},
				error: function (xhr, textStatus, thrownError) {
					console.log('ajax ERROR');
				},
				complete: function () {
					//console.log('ajax PROCESS  COMPLETED');
				}
			});
			
		});
	}
	
	
	dmsLogin(pupupWrapper) {
		if (!pupupWrapper) {
			return;
		}
		
		let form = $(pupupWrapper).find('form');
		let errorBox = $(pupupWrapper).find('.error-box');
		
		// set ajax submit handler
		this.dmsAccountAjaxHandler(form, 'dms/account/user_signin', errorBox);
	}
	
	
	dmsRegistration(pupupWrapper) {
		if (!pupupWrapper) {
			return;
		}
		
		let form = $(pupupWrapper).find('form');
		let errorBox = $(pupupWrapper).find('.error-box');
		
		if (!form.length || !errorBox.length) {
			return;
		}
		
		let email = form.find('[name=email]');
		let pass1 = form.find('[name=pass1]');
		let pass2 = form.find('[name=pass2]');
		
		//let fio = form.find('[name=fio]');
		//let reg_code = form.find('[name=reg_code]');
		//let position = form.find('[name=position]');
		//let phone = form.find('[name=phone]');
		//let company_name = form.find('[name=company_name]');
		//let company_address = form.find('[name=company_address]');
		
		
		// =============  validation
		
		form.validate({
			submitHandler: (formEl, event) => {
				event.preventDefault();
				// set ajax submit handler
				this.dmsAccountAjaxHandler($(formEl), 'dms/account/user_registration', errorBox);
				$(formEl).submit();
			},
		});
		
		email.rules("add", {
			required: true,
			email: true,
			remote: {
				url: themeJsVars.ajaxurl,
				type: "post",
				data: {
					action: 'dms/account/is_user_email_exists',
					ajax_nonce: window.themeJsVars.ajax_nonce,
				}
			},
			messages: {
				remote: themeJsVars.localize['registration/entered_email_exists'],
			}
		});
		
		pass1.rules("add", {
			required: true,
			minlength: 8,
			pwcheck: true,
			messages: {
				pwcheck: window.themeJsVars.localize['registration/password_not_strong']
			}
		});
		
		pass2.rules("add", {
			required: true,
			minlength: 8,
			equalTo: '[name=pass1]',
		});
		
		$.validator.addMethod("pwcheck", function (value) {
			return /[a-z]/.test(value) // has a lowercase letter
				&& /[A-Z]/.test(value) // has a uppercase letter
				&& /\d/.test(value) // has a digit
				&& /[-!$%^&*()_+|~=`{}\[\]:\/;<>?,.@#]/.test(value) // has a special_characters 
		});
	}
	
	
	dmsForgot(pupupWrapper) {
		if (!pupupWrapper) {
			return;
		}
		
		let form = $(pupupWrapper).find('form');
		let errorBox = $(pupupWrapper).find('.error-box');
		
		if (!form.length || !errorBox.length) {
			return;
		}
		
		let email = form.find('[name=email]');
		
		// =============  validation
		
		form.validate({
			submitHandler: (formEl, event) => {
				event.preventDefault();
				// set ajax submit handler
				this.dmsAccountAjaxHandler($(formEl), 'dms/account/user_forgot', errorBox);
				$(formEl).submit();
			},
		});
		
		email.rules("add", {
			required: true,
			email: true,
		});
	}
	
	
	// --------------------------------------------------------------------
	//    DMS API Search 
	// --------------------------------------------------------------------
	dmsApiSearch() {
		'use strict';
		
		const genFieldData = (name, minLength) => {
			return {
				name,
				inputSelector: `#s-test__try_form input[name="${name}"]`,
				action: `dms/api_search/field/${name}`,
				minLength: minLength || 1,
				url: window.themeJsVars.ajaxurl, // common field
				nonce: window.themeJsVars.ajax_nonce,  // common field
			};
		};
		
		dmsSearch(genFieldData('first', 1)).init();
		dmsSearch(genFieldData('middle', 1)).init();
		dmsSearch(genFieldData('city', 1)).init();
		dmsSearch(genFieldData('street', 1)).init();
		dmsSearch(genFieldData('house', 1)).init();
	}
	
	
}
