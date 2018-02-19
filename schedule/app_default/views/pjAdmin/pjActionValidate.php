if (jQuery_1_8_2.validator !== undefined) {
	jQuery_1_8_2.extend(jQuery_1_8_2.validator.messages, {
		required: "<?php __('form_v_required', false, true); ?>",
		remote: "<?php __('form_v_remote', false, true); ?>",
		email: "<?php __('form_v_email', false, true); ?>",
		url: "<?php __('form_v_url', false, true); ?>",
		date: "<?php __('form_v_date', false, true); ?>",
		dateISO: "<?php __('form_v_date_iso', false, true); ?>",
		number: "<?php __('form_v_number', false, true); ?>",
		digits: "<?php __('form_v_digits', false, true); ?>",
		creditcard: "<?php __('form_v_creditcard', false, true); ?>",
		equalTo: "<?php __('form_v_equal_to', false, true); ?>",
		accept: "<?php __('form_v_accept', false, true); ?>",
		maxlength: jQuery_1_8_2.validator.format("<?php __('form_v_maxlength', false, true); ?>"),
		minlength: jQuery_1_8_2.validator.format("<?php __('form_v_minlength', false, true); ?>"),
		rangelength: jQuery_1_8_2.validator.format("<?php __('form_v_rangelength', false, true); ?>"),
		range: jQuery_1_8_2.validator.format("<?php __('form_v_range', false, true); ?>"),
		max: jQuery_1_8_2.validator.format("<?php __('form_v_max', false, true); ?>"),
		min: jQuery_1_8_2.validator.format("<?php __('form_v_min', false, true); ?>")
	});
}