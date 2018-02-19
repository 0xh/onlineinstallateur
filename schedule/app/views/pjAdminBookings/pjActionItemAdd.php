<?php
$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
?>
<form action="" method="post" class="pj-form form">
	<input type="hidden" name="item_add" value="1" />
	<input type="hidden" name="booking_id" value="<?php echo (int) @$_GET['id']; ?>" />
	<input type="hidden" name="tmp_hash" value="<?php echo @$_GET['tmp_hash']; ?>" />
	<div class="b10 p">
		<label class="title"><?php __('booking_date'); ?></label>
		<span class="pj-form-field-custom pj-form-field-custom-after float_left r5">
			<input type="text" name="date" class="pj-form-field w80 datepick pointer required" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" value="<?php echo date($tpl['option_arr']['o_date_format']); ?>" />
			<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
		</span>
	</div>
	<div class="b10 p bEmployee" style="display: none">
		<label class="title"><?php __('booking_employee'); ?></label>
		<span class="data left float_left">---</span>
		<br class="clear_left" />
		<input type="hidden" name="employee_id" value="" class="ignore" />
	</div>
	<div class="b10 p bStartTime" style="display: none">
		<label class="title"><?php __('booking_start_time'); ?></label>
		<span class="data left float_left">---</span>
		<br class="clear_left" />
		<input type="hidden" name="start_ts" value="" class="ignore" />
	</div>
	<div class="b10 p bEndTime" style="display: none">
		<label class="title"><?php __('booking_end_time'); ?></label>
		<span class="data left float_left">---</span>
		<br class="clear_left" />
		<input type="hidden" name="end_ts" value="" class="ignore" />
	</div>
	<div class="b10 p">
		<label class="title"><?php __('booking_service'); ?></label>
		<select name="service_id" class="pj-form-field w300 stock-product">
			<option value="">-- <?php __('booking_service'); ?> --</option>
			<?php
			foreach ($tpl['service_arr'] as $service)
			{
				?><option value="<?php echo $service['id']; ?>"><?php echo pjSanitize::html($service['name']); ?></option><?php
			}
			?>
		</select>
	</div>
	<?php
	if (empty($tpl['service_arr']))
	{
		$titles = __('error_titles', true);
		$bodies = __('error_bodies', true);
		pjUtil::printNotice(@$titles['ABK14'], @$bodies['ABK14']);
	}
	?>
	<div class="item_details" style="display: none"></div>
</form>