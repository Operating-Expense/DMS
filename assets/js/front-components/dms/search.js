export default (options) => {
	'use strict';
	
	let $ = window.jQuery;
	let {name, inputSelector, url, action, nonce, minLength} = options;
	let searchRequest = null;
	let resultBox = $(inputSelector).siblings('.search_result_box').eq(0);
	let form = $(inputSelector).closest('form');
	let parent = $(inputSelector).closest('.s-test__input_rel');
	let extBox = parent.find('.search_result_ext_box');
	
	let resultHandler = null;
	
	switch (name) {
		case 'first':
			resultHandler = (result) => {
				if (!Array.isArray(result) || !result.length) {
					return '';
				}
				
				let resultHtml = '';
				
				result.forEach((item, i, arr) => {
					if (!item.First || !item.First.length) return;
					if (!item.SexId || !item.SexId) return;
					
					resultHtml += `<div class="search_result_row" data-type="Firsts" data-sexid="${item.SexId}">${item.First}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			break;
		case 'middle':
			resultHandler = null;
			break;
		case 'city':
			resultHandler = null;
			break;
		case 'street':
			resultHandler = null;
			break;
		case 'house':
			resultHandler = null;
			break;
	}
	
	return {
		init: () => {
			console.log(`dms search ${action} init...`);
			
			$(inputSelector).on('blur', function (event) {
				resultBox.html('').hide();
			});
			
			$('body').on('click', '.search_result_row', function (event) {
				//event.preventDefault();
				
				console.log(1);
				
				let resultBox = $(this).closest('.search_result_box');
				let value = $(this).text();
				let sexid = $(this).attr('data-sexid');
				let input = $(this).closest('.s-test__input_rel').find('input');
				let extHtml = '';
				
				input.val(value);
				resultBox.html('').hide();
				
				if (sexid === '1') {
					extHtml = `<div class="result_row result_row_gender" data-type="Firsts" data-sexid="${sexid}">♂</div>`;
				} else if (sexid === '2') {
					extHtml = `<div class="result_row result_row_gender" data-type="Firsts" data-sexid="${sexid}">♀</div>`;
				}
				
				extBox.html(extHtml).show();
				
			});
			
			
			
			$(inputSelector).on('keyup', function (event) {
				let that = this,
					value = $(this).val();
				
				console.log('value ', value);
				
				if (value.length >= minLength) {
					if (searchRequest !== null)
						searchRequest.abort();
					searchRequest = $.ajax({
						type: "POST",
						url,
						data: {
							ajax_nonce: nonce,
							action,
							value
						},
						beforeSend: function () {
							console.log('beforeSend');
							resultBox.html('').hide();
							extBox.html('').hide();
						},
						success: function (response) {
							console.log(response);
							
							if (response.success && response.data.result && resultHandler) {
								
								//we need to check if the value is the same
								if (value === $(that).val()) {
									//Receiving the result of search here
									resultHandler(response.data.result);
								} else {
									console.log('fack');
								}
								
								
							} else {
								//resultBox.html('').hide();
							}
							
							if (response.data && response.data.redirect) {
								window.location.href = response.data.redirect;
							}
							
							
						},
						error: function (xhr, textStatus, thrownError) {
							console.log('ajax ERROR');
						}
						,
						complete: function () {
							//console.log('ajax PROCESS  COMPLETED');
						}
					});
				}
			});
			
		}
	};
}