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
	let mainInfoBox = parent.find('.search_result_ext_box');
	
	let shortcode = input.closest('.shortcode-test');
	let extInfoBox = shortcode.find('.extra_info_box');
	
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
					
					let itemToAttr = encodeURIComponent(JSON.stringify(item));
					
					resultHtml += `<div class="search_result_row" data-mainval="${mainValField}" data-item="${itemToAttr}">${mainValField}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				
				let itemData = null;
				try {
					itemData = JSON.parse(decodeURIComponent($resultElement.attr('data-item')));
				} catch (e) {
					console.warn(e.message);
				}
				
				let SexId = itemData ? itemData['SexId'] : '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-sexid', SexId);
				
				if (SexId === '1') {
					extHtml += `<div class="result_row result_row_gender" data-type="${name}">♂</div>`;
				} else if (SexId === '2') {
					extHtml += `<div class="result_row result_row_gender" data-type="${name}">♀</div>`;
				}
				
				mainInfoBox.html(extHtml).show();
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
					
					let itemToAttr = encodeURIComponent(JSON.stringify(item));
					
					resultHtml += `<div class="search_result_row" data-mainval="${mainValField}" data-item="${itemToAttr}">${mainValField}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				let itemData = null;
				try {
					itemData = JSON.parse(decodeURIComponent($resultElement.attr('data-item')));
				} catch (e) {
					console.warn(e.message);
				}
				
				let SexId = itemData ? itemData['SexId'] : '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-sexid', SexId);
				
				if (SexId === '1') {
					extHtml += `<div class="result_row result_row_gender" data-type="${name}">♂</div>`;
				} else if (SexId === '2') {
					extHtml += `<div class="result_row result_row_gender" data-type="${name}">♀</div>`;
				}
				
				mainInfoBox.html(extHtml).show();
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
					
					let valString = mainValField;
					valString = SettlementType ? `<span>${SettlementType} </span>`+ valString : valString;
					valString = Area || Region ? valString + '<div class="srr_subrow">' : valString;
					valString = Area ? valString + `<span>${Area} &nbsp;</span>` : valString;
					valString = Region ? valString + `<span>${Region} </span>` : valString;
					valString = Area || Region ? valString + '</div>' : valString;
					
					let itemToAttr = encodeURIComponent(JSON.stringify(item));
					
					resultHtml += '<div class="search_result_row" ';
					resultHtml += `data-mainval="${mainValField}" `;
					resultHtml += `data-item="${itemToAttr}" `;
					resultHtml += `>${valString}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				let itemData = null;
				try {
					itemData = JSON.parse(decodeURIComponent($resultElement.attr('data-item')));
				} catch (e) {
					console.warn(e.message);
				}
				
				let st_moniker = itemData ? itemData['st_moniker'] : '';
				let Region = itemData ? itemData['Region'] : '';
				let Area = itemData ? itemData['Area'] : '';
				let SettlementType = itemData ? itemData['SettlementType'] : '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-st_moniker', st_moniker);
				
				
				if (SettlementType) {
					extHtml += `<div class="result_row" data-type="${name}">${SettlementType}</div>`;
				}
				if (Area) {
					extHtml += `<div class="result_row" data-type="${name}">${Area}</div>`;
				}
				if (Region) {
					extHtml += `<div class="result_row" data-type="${name}">${Region}</div>`;
				}
				
				mainInfoBox.html(extHtml).show();
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
					
					let StreetType = item.StreetType || '';
					
					let valString = mainValField;
					valString = StreetType ? StreetType + ' ' + valString : valString;
					
					let itemToAttr = encodeURIComponent(JSON.stringify(item));
					
					resultHtml += `<div class="search_result_row" data-mainval="${mainValField}" data-item="${itemToAttr}">${valString}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				
				let itemData = null;
				try {
					itemData = JSON.parse(decodeURIComponent($resultElement.attr('data-item')));
				} catch (e) {
					console.warn(e.message);
				}
				
				let house_moniker = itemData ? itemData['house_moniker'] : '';
				let StreetType = itemData ? itemData['StreetType'] : '';
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				form.attr('data-house_moniker', house_moniker);
				
				if (StreetType) {
					extHtml += `<div class="result_row" data-type="${name}">${StreetType}</div>`;
				}
				
				mainInfoBox.html(extHtml).show();
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
					
					let HouseNumAdd = item.HouseNumAdd || '';
					
					mainValField = mainValField + HouseNumAdd;
					let valString = mainValField;
					
					let itemToAttr = encodeURIComponent(JSON.stringify(item));
					
					resultHtml += `<div class="search_result_row" data-mainval="${mainValField}" data-item="${itemToAttr}">${valString}</div>`;
				});
				
				resultBox.html(resultHtml).show();
			};
			
			extHandler = (resultElement) => {
				let $resultElement = $(resultElement);
				let value = $resultElement.attr('data-mainval') || '';
				
				let itemData = null;
				try {
					itemData = JSON.parse(decodeURIComponent($resultElement.attr('data-item')));
				} catch (e) {
					console.warn(e.message);
				}
				
				let Index_ = itemData ? itemData['Index_'] : '';
				let Lat = itemData ? itemData['Lat'] : '';
				let Long = itemData ? itemData['Long'] : '';
				let CityDistrict = itemData ? itemData['CityDistrict'] : '';
				
				
				let extHtml = '';
				
				input.val(value);
				lastRequest = value;
				input.attr('data-competed', '1');
				resultBox.html('').hide();
				
				if (Lat && Long) {
					extHtml += `<div class="result_row" data-type="${name}">${Lat}, ${Long}</div>`;
				}
				if (Index_) {
					extHtml += `<div class="result_row" data-type="${name}">${Index_}</div>`;
				}
				if (CityDistrict) {
					extHtml += `<div class="result_row" data-type="${name}">${CityDistrict}</div>`;
				}
				
				mainInfoBox.html(extHtml).show();
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
		
		if (name === 'middle' && $.trim(firstVal) !== '1') {
			form.attr('data-sexid', '');
		}
		
		if (name === 'first' && $.trim(middleVal) !== '1') {
			form.attr('data-sexid', '');
		}
	}
	
	
	function genJsonPreview(itemData) {
		if (!(itemData instanceof Object)) {
			return '';
		}
		
		let result = '';
		
		for (let key in itemData) {
			let value = itemData[key] === null ? '-' : itemData[key];
			
			result += '<div class="extra_info_item">';
			result += `<span class="ei_key">${key}</span>`;
			result += '<span class="ei_sep"> : </span>';
			result += `<span class="ei_value">${value}</span>`;
			result += '</div>';
		}
		return result;
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
					mainInfoBox.html('').hide();
				}
			});
			
			
			input.on('input', function (event) {
				mayBeClearSexId();
			});
			
			
			resultBox.on('mouseover', '.search_result_row', function (event) {
				let $this = $(this);
				let itemData = null;
				
				try {
					itemData = JSON.parse(decodeURIComponent($this.attr('data-item')));
				} catch (e) {
					console.warn(e.message);
				}
				
				if (itemData) {
					extInfoBox.html(genJsonPreview(itemData));
					extInfoBox.fadeIn(100);
				}
				
				$this.siblings().removeClass('active');
				$this.addClass('active');
				
			});
			
			resultBox.on('mouseout', '.search_result_row', function (event) {
				let $this = $(this);
				$this.siblings().removeClass('active');
				
				extInfoBox.html('');
				extInfoBox.fadeOut(100);
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
							mainInfoBox.html('').hide();
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
					mainInfoBox.html('').hide();
					input.attr('data-competed', '0');
				}
			});
			
		}
	};
}