'use strict';

$(function() {
	$(document).on('change', '#states', function() {
		var _target = $(this).attr('city-result');
		var stateId = $(this).val();
		var url = $('#cities-url').val();

		var loadingOpt = $('<option>', {'value': '', 'html': 'Carregando cidades'});
		var $el = $(_target);
		$el.empty();
		$el.append(loadingOpt);

		// Set state id on URL
		url += '/index/' + stateId + '.json'

		$.ajax({
			'url': url,
			'method': 'GET',
			success: function(res) {
				var $el = $(_target);

				var basicOpt = $('<option>', {'value': '', 'html': 'Selecione uma cidade'});

				$el.empty();
				$el.append(basicOpt);

				$.each(res.cidades, function(i, item) {
					$el.append(
						$('<option>', {'value': i, 'html': item})
					);
				});
			}	
		});
		// console.log(url, stateId);
	});
});