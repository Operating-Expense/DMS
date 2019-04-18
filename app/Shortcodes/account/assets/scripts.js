;(function ($) {
	
	"use strict";
	
	function filterTextarea(text) {
		if (typeof text === 'string') {
			text = text.replace(/(\r\n|\n|\r)/gm, " "); //This javascript replaces all 3 types of line breaks with a space
			text = text.replace(/\s+/g, " "); //Replace all double white spaces with single spaces
		}
		return text;
	}
	
	
	$(document).ready(function () {
		
		
		$('.shortcode-account').each(function () {
			
			let $shortcode = $(this);
			let $form = $shortcode.find('.dms_user_profile');
			let $edit = $shortcode.find('.pf_action_edit');
			let $save = $shortcode.find('.pf_action_save');
			let $errorBox = $shortcode.find('.pf_error_box');
			
			let $editable_boxes = $shortcode.find('.item_editable');
			
			let $avaBoxWraper = $shortcode.find('.profile-ava-wrapper');
			let $controlAvaLabel = $avaBoxWraper.find('.pf_ava_label');
			let $controlAva = $avaBoxWraper.find('.pf_ava');
			let $avaImgBox = $avaBoxWraper.find('.profile-ava');
			let $avaImg = $avaBoxWraper.find('.profile-ava-img');
			
			
			$edit.on('click', function (event) {
				event.preventDefault();
				
				$editable_boxes.each(function () {
					let $box = $(this);
					let $savedValue = $box.find('.item_value');
					let $control = $box.find('.pf_control');
					
					$savedValue.hide();
					$control.val($.trim($savedValue.text())).show();
				});
				
				$controlAvaLabel.show();
				
				$edit.hide();
				$save.show();
				
				
			});
			
			
			$save.on('click', function (event) {
				event.preventDefault();
				$form.submit();
			});
			
			
			$form.on('submit', function (event) {
				event.preventDefault();
				
				let formData = new FormData(this);
				formData.append('action', 'dms/account/user_save_profile');
				formData.append('ajax_nonce', window.themeJsVars.ajax_nonce);
				formData.append('action', 'dms/account/user_save_profile');
				
				$.ajax({
					type: "POST",
					url: themeJsVars.ajaxurl,
					enctype: 'multipart/form-data',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {
						$errorBox.html('');
					},
					success: function (response) {
						//console.log('response>>', response);
						
						if (response.success && response.data && response.data.saved) {
							let saved = response.data.saved;
							
							$editable_boxes.each(function () {
								let $box = $(this);
								let $savedValue = $box.find('.item_value');
								let $control = $box.find('.pf_control');
								let controlName = $control.attr('name');
								if (saved[controlName] !== undefined) {
									$savedValue.text(saved[controlName]).show();
								}
								$control.val('').hide();
							});
							
							$controlAvaLabel.hide();
							$edit.show();
							$save.hide();
							
						} else if (response.data) {
							$errorBox.html(response.data.error_html);
						}
					},
					error: function (xhr, textStatus, thrownError) {
						//console.log('ajax ERROR');
					},
					complete: function () {
						//console.log('ajax PROCESS  COMPLETED');
					}
				});
				
				
			});
			
			
			// AVA
			
			$controlAva.change(function (event) {
				if ($avaImg.length) {
					readURL(this, $avaImg);
				} else {
					let img = createImg('#', 'profile-ava-img');
					readURL(this, img);
					$avaImgBox.html('').append(img);
				}
			});
			
			
			function readURL(input, img) {
				if (input.files && input.files[0]) {
					let reader = new FileReader();
					reader.onload = function (e) {
						$(img).removeAttr('srcset');
						$(img).attr('src', e.target.result);
					};
					reader.readAsDataURL(input.files[0]);
				}
			}
			
			
			function createImg(src, className, alt, title) {
				let img = window.IEWIN ? new Image() : document.createElement('img');
				img.src = src;
				if (className != null) img.className = className;
				if (alt != null) img.alt = alt;
				if (title != null) img.title = title;
				return img;
			}
			
			
		});
	});
	
	
})(window.jQuery);