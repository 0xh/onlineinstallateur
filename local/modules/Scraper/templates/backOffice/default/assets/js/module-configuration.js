$('body').on('submit', '.scraperform', function (e) {
	e.preventDefault();
	$.ajax({
		type: $(this).attr('method'),
		url: $(this).attr('action'),
		data: $(this).serialize(),
	})
	.done(function (data, textStatus, request) {
		$("#scraper_response").empty().append(data);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		if (typeof jqXHR.responseJSON !== 'undefined') {
			if (jqXHR.responseJSON.hasOwnProperty('form')) {
				$('#form_body').html(jqXHR.responseJSON.form);
			}
			$('.form_error').html(jqXHR.responseJSON.message);
		} else {
			alert(errorThrown);
		}
	});
});