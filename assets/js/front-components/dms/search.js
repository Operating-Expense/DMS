export default (options) => {
	'use strict';
	
	let $ = window.jQuery;
	let {name, inputSelector, url, action, nonce, minLength} = options;
	let searchRequest = null;
	
	let input = $(inputSelector);
	let resultBox = input.siblings('.search_result_box').eq(0);
	let form = input.closest('form');
	let mainWraper = $('#main-wrapper');
	
	let parent = input.closest('[data-sbname]');
	let extBox = parent.find('.search_result_ext_box');
	
	let resultHandler = null, extHandler = null;
	
	let langMap = {
		"ru": "ru_RU",
		"uk": "uk_UA",
		"en": "en_UK",
	};
	
	let currentSiteLang = window.WPGlobus.language;
	let lang = langMap[currentSiteLang] === undefined ? '' : langMap[currentSiteLang];
	
	let lastRequest = '';
	
	switch (name) {
		
		case 'first':
			// =======================================================
			resultHandler = (result) => {
				if (!Array.isArray(result) || !result.length) {
					return '';
				}
				
				let resultHtml = '';
				
				result.forEach((item, i, arr) => {
					let mainValField = item.First;
					
					if (!mainValField || !mainValField.length) return;
					
					let SexId = item.SexId || '';
					
					resultHtml += `<div class="search_result_row" data-mainval="${mainValField}" data-sexid="${SexId}">${mainValField}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				let sexid = $resultElement.attr('data-sexid') || '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-sexid', sexid);
				
				if (sexid === '1') {
					extHtml += `<div class="result_row result_row_gender" data-sexid="${sexid}">♂</div>`;
				} else if (sexid === '2') {
					extHtml += `<div class="result_row result_row_gender" data-sexid="${sexid}">♀</div>`;
				}
				
				extBox.html(extHtml).show();
			};
			
			break;
		case 'middle':
			// =======================================================
			resultHandler = (result) => {
				if (!Array.isArray(result) || !result.length) {
					return '';
				}
				
				let resultHtml = '';
				
				result.forEach((item, i, arr) => {
					let mainValField = item.Middle;
					
					if (!mainValField || !mainValField.length) return;
					
					let SexId = item.SexId || '';
					
					resultHtml += `<div class="search_result_row" data-mainval="${mainValField}" data-sexid="${SexId}">${mainValField}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				let sexid = $resultElement.attr('data-sexid') || '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-sexid', sexid);
				
				if (sexid === '1') {
					extHtml += `<div class="result_row result_row_gender" data-sexid="${sexid}">♂</div>`;
				} else if (sexid === '2') {
					extHtml += `<div class="result_row result_row_gender" data-sexid="${sexid}">♀</div>`;
				}
				
				extBox.html(extHtml).show();
			};
			
			break;
		// =======================================================
		case 'city':
			// =======================================================
			resultHandler = (result) => {
				if (!Array.isArray(result) || !result.length) {
					return '';
				}
				
				let resultHtml = '';
				
				result.forEach((item, i, arr) => {
					let mainValField = item.City;
					
					if (!mainValField || !mainValField.length) return;
					
					let SettlementType = item.SettlementType || '';
					let Area = item.Area || '';
					let Region = item.Region || '';
					let st_moniker = item.st_moniker || '';
					
					let valString = mainValField;
					valString = SettlementType ? SettlementType + ' ' + valString : valString;
					valString = Area ? valString + ', ' + Area : valString;
					valString = Region ? valString + ', ' + Region : valString;
					
					resultHtml += `<div class="search_result_row" data-st_moniker="${st_moniker}" data-mainval="${mainValField}" data-region="${Region}" data-area="${Area}">${valString}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				let st_moniker = $resultElement.attr('data-st_moniker') || '';
				let region = $resultElement.attr('data-region') || '';
				let area = $resultElement.attr('data-area') || '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-st_moniker', st_moniker);
				
				
				if (area) {
					extHtml += `<div class="result_row" data-type="${name}" data-area="${area}">${area}</div>`;
				}
				if (region) {
					extHtml += `<div class="result_row" data-type="${name}" data-area="${region}">${region}</div>`;
				}
				
				extBox.html(extHtml).show();
			};
			break;
		// =======================================================
		case 'street':
			// =======================================================
			resultHandler = (result) => {
				if (!Array.isArray(result) || !result.length) {
					return '';
				}
				
				let resultHtml = '';
				
				result.forEach((item, i, arr) => {
					let mainValField = item.Street;
					
					if (!mainValField || !mainValField.length) return;
					
					let house_moniker = item.house_moniker || '';
					let StreetType = item.StreetType || '';
					
					let valString = mainValField;
					valString = StreetType ? StreetType + ' ' + valString : valString;
					
					resultHtml += `<div class="search_result_row" data-house_moniker="${house_moniker}" data-mainval="${mainValField}">${valString}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				let house_moniker = $resultElement.attr('data-house_moniker') || '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-house_moniker', house_moniker);
				
				extBox.html(extHtml).show();
			};
			break;
		// =======================================================
		case 'house':
			// =======================================================
			resultHandler = (result) => {
				if (!Array.isArray(result) || !result.length) {
					return '';
				}
				
				let resultHtml = '';
				
				result.forEach((item, i, arr) => {
					let mainValField = item.HouseNum;
					
					if (!mainValField || !mainValField.length) return;
					
					let Index_ = item.Index_ || '';
					let Lat = item.Lat || '';
					let Long = item.Long || '';
					let HouseNumAdd = item.HouseNumAdd || '';
					
					mainValField = mainValField + HouseNumAdd;
					let valString = mainValField;
					
					
					resultHtml += `<div class="search_result_row" data-mainval="${mainValField}" data-index="${Index_}"  data-lat="${Lat}" data-long="${Long}">${valString}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				let index = $resultElement.attr('data-index') || '';
				let lat = $resultElement.attr('data-lat') || '';
				let long = $resultElement.attr('data-long') || '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				
				if (lat && long) {
					extHtml += `<div class="result_row" data-type="${name}" data-lat="${lat}" data-long="${long}">${lat}, ${long}</div>`;
				}
				if (index) {
					extHtml += `<div class="result_row" data-type="${name}" data-index="${index}">${index}</div>`;
				}
				
				extBox.html(extHtml).show();
			};
			break;
		// =======================================================
	}
	
	
	function escHtml(text) {
		let map = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#039;'
		};
		
		if (typeof text === 'string') {
			return text.replace(/[&<>"']/g, function (m) {
				return map[m];
			});
		}
		return text;
	}
	
	
	function mayBeClearSexId() {
		let firstVal = form.find('input[name=first]').attr('data-competed');
		let middleVal = form.find('input[name=middle]').attr('data-competed');
		
		if ( name === 'middle' && $.trim(firstVal) !== '1') {
			form.attr('data-sexid', '');
		}
		
		if ( name === 'first' && $.trim(middleVal) !== '1') {
			form.attr('data-sexid', '');
		}
	}
	
	// ========================================================================
	// ========================================================================
	return {
		init: () => {
			
			
			mainWraper.on('click', `[data-sbname="${name}"] .search_result_row`, function (event) {
				if (extHandler) {
					extHandler(this);
				}
			});
			
			
			mainWraper.on('click', function (event) {
				resultBox.html('').hide();
				if ($.trim(input.val()) === '') {
					input.attr('data-competed', '0');
					extBox.html('').hide();
				}
			});
			
			input.on('input', function (event) {
				mayBeClearSexId();
			});
			
			
			//=================================================
			// API Request
			//=================================================
			input.on('keyup', function (event) {
				let that = this,
					value = $(this).val();
				
				
				if (lastRequest === value) {
					return;
				}
				
				lastRequest = value;
				
				if (value.length >= minLength) {
					if (searchRequest !== null)
						searchRequest.abort();
					searchRequest = $.ajax({
						type: "POST",
						url,
						data: {
							ajax_nonce: nonce,
							action,
							value,
							st_moniker: form.attr('data-st_moniker') || null,
							house_moniker: form.attr('data-house_moniker') || null,
							SexId: form.attr('data-sexid') || null,
							Lang: lang
						},
						beforeSend: function () {
							resultBox.html('').hide();
							extBox.html('').hide();
							input.attr('data-competed', '0');
						},
						success: function (response) {
							console.log(response);
							
							if (response.success && response.data.result && resultHandler) {
								//we need to check if the value is the same
								if (value === $(that).val() && value) {
									//Receiving the result of search here
									resultHandler(response.data.result);
								} else {
									console.log('>>  value is not the same');
								}
							}
							
							// redirect if need
							if (response.data && response.data.redirect) {
								window.location.href = response.data.redirect;
							}
						},
						error: function (xhr, textStatus, thrownError) {
							//console.log('ajax ERROR');
						},
						complete: function () {
							//console.log('ajax PROCESS  COMPLETED');
						}
					});
					
				} else {
					resultBox.html('').hide();
					extBox.html('').hide();
					input.attr('data-competed', '0');
				}
			});
			
		}
	};
}