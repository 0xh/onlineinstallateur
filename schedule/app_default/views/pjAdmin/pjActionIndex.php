<?php
if (isset($tpl['status']))
{
	$status = __('status', true);
	switch ($tpl['status'])
	{
		case 2:
			pjUtil::printNotice(NULL, $status[2]);
			break;
	}
} else {
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	pjUtil::printNotice(@$titles['AD01'], @$bodies['AD01'], true, false);
	
	$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
	$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
	
	$booking_statuses = __('booking_statuses', true, true);
	$invoice_statuses = __('plugin_invoice_statuses', true, true);
	$filter = __('filter', true, true);
	?>
	<div class="b10">
		<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdmin&amp;action=pjActionIndex&amp;date=<?php echo date('Y-m-d'); ?>" class="pj-button btnToday float_left inline_block r5"><?php __('btnToday'); ?></a>
		<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdmin&amp;action=pjActionIndex&amp;date=<?php echo date('Y-m-d', strtotime("+1 day")); ?>" class="pj-button btnTomorrow float_left inline_block r5"><?php __('btnTomorrow'); ?></a>
		<span class="float_left">
			<span class="pj-form-field-custom pj-form-field-custom-after">
				<input type="text" name="dt" class="pj-form-field w80 datepick pointer required" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" value="<?php echo isset($_GET['date']) && !empty($_GET['date']) ? date($tpl['option_arr']['o_date_format'], strtotime($_GET['date'])) : date($tpl['option_arr']['o_date_format']); ?>" />
				<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
			</span>
		</span>
		<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdmin&amp;action=pjActionPrint&amp;date=<?php echo isset($_GET['date']) && !empty($_GET['date']) ? urlencode($_GET['date']) : date("Y-m-d"); ?>" target="_blank" class="pj-button btnPrint float_right inline_block"><?php __('report_print'); ?></a>
		<br class="clear_both" />
	</div>
	<?php
	if (!$tpl['t_arr'])
	{
		pjUtil::printNotice(@$titles['AD02'], @$bodies['AD02'], true, false);
	} else {
		if (empty($tpl['service_arr']))
		{
			
		} else {
			# Fix for 24h support
			$offset = $tpl['t_arr']['end_ts'] <= $tpl['t_arr']['start_ts'] ? 86400 : 0;
			$step = $tpl['option_arr']['o_step'] * 60;
			?>
			<div class="dContainer">
				<div class="dWrapper">
					<table class="pj-table dTable" cellpadding="0" cellspacing="0">
						<tr>
							<td class="dHeadcol"></td>
						<?php
						foreach ($tpl['employee_arr'] as $employee)
						{
							?><td class="dHead"><?php echo pjSanitize::html($employee['name']); ?></td><?php
						}
						?>
						</tr>
						<?php
						for ($i = $tpl['t_arr']['start_ts']; $i <= $tpl['t_arr']['end_ts'] + $offset - $step; $i += $step)
						{
							?>
							<tr>
								<td class="dHeadcol"><?php echo date($tpl['option_arr']['o_time_format'], $i); ?></td>
								<?php
								foreach ($tpl['employee_arr'] as $employee)
								{
									$bookings = array();
									foreach ($tpl['bs_arr'] as $item)
									{
										if ($employee['id'] == $item['employee_id'] && $i >= $item['start_ts'] && $i < $item['start_ts'] + $item['total'] * 60)
										{
											$bookings[] = $item;
										}
									}
									
									$slots_per_employee = pjAppController::getRawSlotsPerEmployee($employee['id'], date('Y-m-d', $i), $controller->getForeignId());
									$is_available = false;
									$slot = '';
									$service_id = '';
									if(!empty($slots_per_employee))
									{
										foreach($employee['services'] as $service)
										{
											$step = $tpl['option_arr']['o_step'] * 60;
											list($service_id, $service_length, $service_before) = explode("|", $service);
											$service_length = $service_length * 60;
											$service_before = $service_before * 60;
											$service_id = $service_id;
											$_offset = $slots_per_employee['end_ts'] <= $slots_per_employee['start_ts'] ? 86400 : 0;
											$class = 'asUnavailable';
											$interval = $tpl['t_arr']['start_ts'] - $slots_per_employee['start_ts'];
											$ii = $i;
											$is_free = true;
											if($interval == 0)
											{
												$ii = $i;
											}else if($interval < 0){
												$ii = $i + $interval;
											}	
											if ($ii < time())
											{
												$is_free = false;
												$class = "asSlotUnavailable";
												break;
											}
											if ($ii >= $slots_per_employee['lunch_start_ts'] && $ii < $slots_per_employee['lunch_end_ts'])
											{
												$is_free = false;
												$class = "asSlotUnavailable";
												break;
											}
											# Before lunch break
											if ($ii + $service_length - $service_before > $slots_per_employee['lunch_start_ts'] && $ii < $slots_per_employee['lunch_end_ts'])
											{
												$is_free = false;
												$class = "asSlotUnavailable";
											}
											if ($is_free)
											{
												if ($ii + $service_length - $service_before > $slots_per_employee['end_ts'] + $_offset)
												{
													// end of working day
													$class = "asSlotUnavailable";
												}
											}
											if($class == 'asUnavailable')
											{
												$is_available = true;
												$slot = $ii;
												break;
											}
										}
											
									}
									?><td class="dSlot<?php echo $is_available == true ? ' available' : null;?>"><?php
									if (empty($bookings))
									{
										echo str_repeat('-', 3);
										if ($controller->isAdmin())
										{
											?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionCreate" class="pj-table-icon-add"></a><?php
										}
									} else {
										foreach ($bookings as $booking)
										{
											?>
											<div class="">
												<?php if ($controller->isEmployee()) : ?>
												<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionList" class="employee-booking" data-id="<?php echo $booking['id']; ?>"><?php echo pjSanitize::html($booking['c_name']); ?></a><br/>
												<?php else : ?>
												<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate&amp;id=<?php echo $booking['booking_id']; ?>"><?php echo pjSanitize::html($booking['c_name']); ?></a><br/>
												<?php endif; ?>
												<span class="fs11"><?php echo pjSanitize::html($booking['service_name']); ?></span>
											</div>
											<?php
										}
									}
									?></td><?php
								}
								?>
							</tr>
							<?php
						}
						?>
					</table>
				</div>
			</div>
			<?php if ($controller->isEmployee()) : ?>
			<div id="dialogView" title="<?php __('booking_view_title', false, true); ?>" style="display: none"></div>
			<?php endif; ?>
			<?php
		}
	}
	$day_names = __('day_names', true);
	$months = __('months', true);
	ksort($day_names);
	ksort($months);
	?>
	<script type="text/javascript">
	var myLabel = myLabel || {};
	myLabel.monthNames = ["<?php echo join('","', $months); ?>"];
	myLabel.dayNamesMin = ["<?php echo join('","', $day_names); ?>"];
	</script>
	<?php
}
?>