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
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate" method="post" id="frmUpdateBooking" class="form pj-form frmBooking">
		<input type="hidden" name="booking_update" value="1" />
		<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php __('booking_tab_details'); ?></a></li>
				<li><a href="#tabs-2"><?php __('booking_tab_client'); ?></a></li>
				<?php
				if (pjObject::getPlugin('pjInvoice') !== NULL)
				{
					?><li><a href="#tabs-3"><?php __('plugin_invoice_menu_invoices'); ?></a></li><?php
				}
				?>
			</ul>
			
			<div id="tabs-1">
				<?php pjUtil::printNotice(@$titles['ABK12'], @$bodies['ABK12']); ?>
				<fieldset class="fieldset white">
					<legend><?php __('booking_general'); ?></legend>
					<div>
						<div class="float_left w350">
							<p>
								<label class="title"><?php __('booking_created'); ?>:</label>
								<span class="left"><?php echo date($tpl['option_arr']['o_datetime_format'], strtotime($tpl['arr']['created'])); ?></span>
							</p>
							<p>
								<label class="title"><?php __('booking_uuid'); ?>:</label>
								<input type="text" name="uuid" id="uuid" class="pj-form-field w100 required" value="<?php echo pjSanitize::html($tpl['arr']['uuid']); ?>" />
							</p>
							<p>
								<label class="title"><?php __('booking_status'); ?>:</label>
								<select name="booking_status" id="booking_status" class="pj-form-field required">
									<option value=""><?php __('booking_choose'); ?></option>
									<?php
									foreach (__('booking_statuses', true) as $k => $v)
									{
										?><option value="<?php echo $k; ?>"<?php echo $tpl['arr']['booking_status'] == $k ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
									}
									?>
								</select>
							</p>
							
						</div>
						<div class="float_right w350">
							<p>
								<label class="title"><?php __('booking_client'); ?>:</label>
								<span class="left"><a href="#" class="apClientName"><?php echo pjSanitize::html($tpl['arr']['c_name']); ?></a></span>
							</p>
							<p>
								<label class="title"><?php __('email'); ?>:</label>
								<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_email']); ?></span>
							</p>
							<p>
								<label class="title"><?php __('lblIp'); ?>:</label>
								<span class="left"><?php echo pjSanitize::html($tpl['arr']['ip']); ?></span>
							</p>
						</div>
					</div>
					<br class="clear_both" />
					<div class="t10"></div>
					<div class="p">
						<label class="title"><?php __('booking_services'); ?>:</label>
						<div id="boxBookingItems"></div>
						<input type="hidden" name="booking_items" value=""/>
						<div id="dialogItemDelete" title="<?php __('booking_service_delete_title', false, true); ?>" style="display: none"><?php __('booking_service_delete_body'); ?></div>
						<div id="dialogItemAdd" title="<?php __('booking_service_add_title', false, true); ?>" style="display: none"></div>
						<div id="dialogItemEmail" title="<?php __('booking_service_email_title', false, true); ?>" style="display: none"></div>
						<div id="dialogItemSms" title="<?php __('booking_service_sms_title', false, true); ?>" style="display: none"></div>
					</div>
					<p>
						<label class="title">&nbsp;</label>
						<input type="button" value="<?php __('booking_service_add', false, true); ?>" class="pj-button item-add" />
						<input type="button" value="<?php __('booking_recalc', false, true); ?>" class="pj-button order-calc" />
					</p>
					<div class="float_left w350 t15">
						<p>
							<label class="title"><?php __('booking_payment_method'); ?>:</label>
							<select name="payment_method" id="payment_method" class="pj-form-field w120 required">
								<option value=""><?php __('booking_choose'); ?></option>
								<?php
								foreach (__('payment_methods', true) as $k => $v)
								{
									?><option value="<?php echo $k; ?>"<?php echo $tpl['arr']['payment_method'] == $k ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
								}
								?>
							</select>
						</p>
						<p class="erCC" style="display: <?php echo $tpl['arr']['payment_method'] != 'creditcard' ? 'none' : 'block'; ?>">
							<label class="title"><?php __('booking_cc_type'); ?></label>
							<span class="inline_block">
								<select name="cc_type" class="pj-form-field w120">
									<option value="">---</option>
									<?php
									foreach (__('booking_cc_types', true) as $k => $v)
									{
										?><option value="<?php echo $k; ?>"<?php echo $k != $tpl['arr']['cc_type'] ? NULL : ' selected="selected"'; ?>><?php echo $v; ?></option><?php
									}
									?>
								</select>
							</span>
						</p>
						<p class="erCC" style="display: <?php echo $tpl['arr']['payment_method'] != 'creditcard' ? 'none' : 'block'; ?>">
							<label class="title"><?php __('booking_cc_num'); ?></label>
							<span class="inline_block">
								<input type="text" name="cc_num" id="cc_num" class="pj-form-field w120 digits" value="<?php echo pjSanitize::html($tpl['arr']['cc_num']); ?>" />
							</span>
						</p>
						<p class="erCC" style="display: <?php echo $tpl['arr']['payment_method'] != 'creditcard' ? 'none' : 'block'; ?>">
							<label class="title"><?php __('booking_cc_code'); ?></label>
							<span class="inline_block">
								<input type="text" name="cc_code" id="cc_code" class="pj-form-field w120 digits" value="<?php echo pjSanitize::html($tpl['arr']['cc_code']); ?>" />
							</span>
						</p>
						<p class="erCC" style="display: <?php echo $tpl['arr']['payment_method'] != 'creditcard' ? 'none' : 'block'; ?>">
							<label class="title"><?php __('booking_cc_exp'); ?></label>
							<span class="inline_block">
								<?php
								echo pjTime::factory()
									->attr('name', 'cc_exp_month')
									->attr('id', 'cc_exp_month')
									->attr('class', 'pj-form-field')
									->prop('format', 'M')
									->prop('selected', $tpl['arr']['cc_exp_month'])
									->month();
								?>
								<?php
								echo pjTime::factory()
									->attr('name', 'cc_exp_year')
									->attr('id', 'cc_exp_year')
									->attr('class', 'pj-form-field')
									->prop('left', 0)
									->prop('right', 10)
									->prop('selected', $tpl['arr']['cc_exp_year'])
									->year();
								?>
							</span>
						</p>
						<p>
							<label class="title"><?php __('booking_price'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_price" id="booking_price" class="pj-form-field number w90 required" readonly="readonly" value="<?php echo number_format(@$tpl['arr']['booking_price'], 2, ".", ""); ?>" />
							</span>
						</p>
						<p>
							<label class="title"><?php __('booking_deposit'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_deposit" id="booking_deposit" class="pj-form-field number w90" readonly="readonly" value="<?php echo number_format(@$tpl['arr']['booking_deposit'], 2, ".", ""); ?>" />
							</span>
						</p>
						<p>
							<label class="title"><?php __('booking_tax'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_tax" id="booking_tax" class="pj-form-field number w90" readonly="readonly" value="<?php echo number_format(@$tpl['arr']['booking_tax'], 2, ".", ""); ?>" />
							</span>
						</p>
						<p>
							<label class="title"><?php __('booking_total'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_total" id="booking_total" class="pj-form-field number w90" readonly="readonly" value="<?php echo number_format(@$tpl['arr']['booking_total'], 2, ".", ""); ?>" />
							</span>
						</p>
						<p>
							<label class="title">&nbsp;</label>
							<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button" />
							<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminBookings&action=pjActionIndex';" />
						</p>
					</div>
					<div class="float_right w350 t15">
						<p>
							<label class="title"><?php __('booking_notes'); ?>:</label>
							<textarea name="c_notes" id="c_notes" class="pj-form-field w334 h120"><?php echo pjSanitize::html($tpl['arr']['c_notes']); ?></textarea>
						</p>
					</div>
				</fieldset>
			</div>
			<div id="tabs-2">
				<?php pjUtil::printNotice(@$titles['ABK13'], @$bodies['ABK13']); ?>
				<fieldset class="fieldset white">
					<legend><?php __('booking_customer'); ?></legend>
					
					<div class="float_left w360">
						<p>
							<label class="title"><?php __('booking_country'); ?>:</label>
							<select name="c_country_id" id="c_country_id" class="pj-form-field w180 custom-chosen">
								<option value=""><?php __('booking_choose'); ?></option>
								<?php
								foreach ($tpl['country_arr'] as $country)
								{
									?><option value="<?php echo $country['id']; ?>"<?php echo $country['id'] == $tpl['arr']['c_country_id'] ? ' selected="selected"' : NULL; ?>><?php echo pjSanitize::html($country['name']); ?></option><?php
								}
								?>
							</select>
						</p>
						<p>
							<label class="title"><?php __('booking_state'); ?>:</label>
							<input type="text" name="c_state" id="c_state" class="pj-form-field w180" value="<?php echo pjSanitize::html($tpl['arr']['c_state']); ?>" />
						</p>
					</div>
					<div class="float_right w350">
						<p>
							<label class="title"><?php __('booking_city'); ?>:</label>
							<input type="text" name="c_city" id="c_city" class="pj-form-field w160" value="<?php echo pjSanitize::html($tpl['arr']['c_city']); ?>" />
						</p>
						<p>
							<label class="title"><?php __('booking_zip'); ?>:</label>
							<input type="text" name="c_zip" id="c_zip" class="pj-form-field w80" value="<?php echo pjSanitize::html($tpl['arr']['c_zip']); ?>" />
						</p>
					</div>
					<br class="clear_both" />
					<p>
						<label class="title"><?php __('booking_name'); ?>:</label>
						<input type="text" name="c_name" id="c_name" class="pj-form-field w300 required" value="<?php echo pjSanitize::html($tpl['arr']['c_name']); ?>" />
					</p>
					<p>
						<label class="title"><?php __('booking_email'); ?>:</label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
							<input type="text" name="c_email" id="c_email" class="pj-form-field email w250" value="<?php echo pjSanitize::html($tpl['arr']['c_email']); ?>" />
						</span>
					</p>
					<p>
						<label class="title"><?php __('booking_phone'); ?>:</label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
							<input type="text" name="c_phone" id="c_phone" class="pj-form-field w250" value="<?php echo pjSanitize::html($tpl['arr']['c_phone']); ?>" />
						</span>
					</p>
					<p>
						<label class="title"><?php __('booking_address_1'); ?>:</label>
						<input type="text" name="c_address_1" id="c_address_1" class="pj-form-field w500" value="<?php echo pjSanitize::html($tpl['arr']['c_address_1']); ?>" />
					</p>
					<p>
						<label class="title"><?php __('booking_address_2'); ?>:</label>
						<input type="text" name="c_address_2" id="c_address_2" class="pj-form-field w500" value="<?php echo pjSanitize::html($tpl['arr']['c_address_2']); ?>" />
					</p>
					<p>
						<label class="title">&nbsp;</label>
						<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button" />
						<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminBookings&action=pjActionIndex';" />
					</p>
				</fieldset>
				
			</div>
			<?php
			if (pjObject::getPlugin('pjInvoice') !== NULL)
			{
				?>
				<div id="tabs-3">
					<input type="button" class="pj-button btnCreateInvoice" value="<?php __('booking_create_invoice', false, true); ?>" />
					<div id="grid_invoices" class="t10 b10"></div>
				</div>
				<?php
			}
			?>
		</div>
	</form>
	
	<?php
	if (pjObject::getPlugin('pjInvoice') !== NULL)
	{
		$map = array(
			'confirmed' => 'paid',
			'pending' => 'not_paid',
			'cancelled' => 'cancelled'
		);
		?>
		<form action="<?php echo PJ_INSTALL_URL; ?>index.php" method="get" target="_blank" style="display: inline" id="frmCreateInvoice">
			<input type="hidden" name="controller" value="pjInvoice" />
			<input type="hidden" name="action" value="pjActionCreateInvoice" />
			<input type="hidden" name="tmp" value="<?php echo md5(uniqid(rand(), true)); ?>" />
			<input type="hidden" name="uuid" value="<?php echo pjUtil::uuid(); ?>" />
			<input type="hidden" name="order_id" value="<?php echo pjSanitize::html($tpl['arr']['uuid']); ?>" />
			<input type="hidden" name="issue_date" value="<?php echo date('Y-m-d'); ?>" />
			<input type="hidden" name="due_date" value="<?php echo date('Y-m-d'); ?>" />
			<input type="hidden" name="status" value="<?php echo @$map[$tpl['arr']['booking_status']]; ?>" />
			<input type="hidden" name="subtotal" value="<?php echo $tpl['arr']['booking_price']; ?>" />
			<input type="hidden" name="discount" value="0.00" />
			<input type="hidden" name="tax" value="<?php echo $tpl['arr']['booking_tax']; ?>" />
			<input type="hidden" name="shipping" value="0.00" />
			<input type="hidden" name="total" value="<?php echo $tpl['arr']['booking_total']; ?>" />
			<input type="hidden" name="paid_deposit" value="0.00" />
			<input type="hidden" name="amount_due" value="0.00" />
			<input type="hidden" name="currency" value="<?php echo pjSanitize::html($tpl['option_arr']['o_currency']); ?>" />
			<input type="hidden" name="notes" value="<?php echo pjSanitize::html($tpl['arr']['c_notes']); ?>" />
			<input type="hidden" name="b_billing_address" value="<?php echo pjSanitize::html($tpl['arr']['c_address_1']); ?>" />
			<input type="hidden" name="b_name" value="<?php echo pjSanitize::html($tpl['arr']['c_name']); ?>" />
			<input type="hidden" name="b_address" value="<?php echo pjSanitize::html($tpl['arr']['c_address_1']); ?>" />
			<input type="hidden" name="b_street_address" value="<?php echo pjSanitize::html($tpl['arr']['c_address_2']); ?>" />
			<input type="hidden" name="b_city" value="<?php echo pjSanitize::html($tpl['arr']['c_city']); ?>" />
			<input type="hidden" name="b_state" value="<?php echo pjSanitize::html($tpl['arr']['c_state']); ?>" />
			<input type="hidden" name="b_zip" value="<?php echo pjSanitize::html($tpl['arr']['c_zip']); ?>" />
			<input type="hidden" name="b_phone" value="<?php echo pjSanitize::html($tpl['arr']['c_phone']); ?>" />
			<input type="hidden" name="b_email" value="<?php echo pjSanitize::html($tpl['arr']['c_email']); ?>" />
			<?php
			$items = array();
			if (isset($tpl['bi_arr']) && !empty($tpl['bi_arr']))
			{
				foreach ($tpl['bi_arr'] as $i => $attr)
				{
					$items[$i] = array(
						'name' => $attr['title'],
						'description' => NULL,
						'qty' => 1,
						'unit_price' => $attr['price'],
						'amount' => number_format(1 * $attr['price'], 2, ".", "")
					);
					?>
					<input type="hidden" name="items[<?php echo $i; ?>][name]" value="<?php echo pjSanitize::html($items[$i]['name']); ?>" />
					<input type="hidden" name="items[<?php echo $i; ?>][description]" value="<?php echo pjSanitize::html($items[$i]['description']); ?>" />
					<input type="hidden" name="items[<?php echo $i; ?>][qty]" value="<?php echo $items[$i]['qty']; ?>" />
					<input type="hidden" name="items[<?php echo $i; ?>][unit_price]" value="<?php echo $items[$i]['unit_price']; ?>" />
					<input type="hidden" name="items[<?php echo $i; ?>][amount]" value="<?php echo $items[$i]['amount']; ?>" />
					<?php
				}
				?>
				<input type="hidden" name="items[<?php echo $i+2; ?>][name]" value="<?php __('booking_shipping', false, true); ?>" />
				<input type="hidden" name="items[<?php echo $i+2; ?>][description]" value="" />
				<input type="hidden" name="items[<?php echo $i+2; ?>][qty]" value="1" />
				<input type="hidden" name="items[<?php echo $i+2; ?>][unit_price]" value="<?php echo @$tpl['arr']['shipping']; ?>" />
				<input type="hidden" name="items[<?php echo $i+2; ?>][amount]" value="<?php echo @$tpl['arr']['shipping']; ?>" />
				<?php
			} else {
				$items[0] = array(
					'name' => 'Booking payment',
					'description' => '',
					'qty' => 1,
					'unit_price' => $tpl['arr']['booking_total'],
					'amount' => $tpl['arr']['booking_total']
				);
				?>
				<input type="hidden" name="items[0][name]" value="<?php echo pjSanitize::html($items[0]['name']); ?>" />
				<input type="hidden" name="items[0][description]" value="<?php echo pjSanitize::html($items[0]['description']); ?>" />
				<input type="hidden" name="items[0][qty]" value="<?php echo $items[0]['qty']; ?>" />
				<input type="hidden" name="items[0][unit_price]" value="<?php echo $items[0]['unit_price']; ?>" />
				<input type="hidden" name="items[0][amount]" value="<?php echo $items[0]['amount']; ?>" />
				<?php
			}
			?>
		</form>
		<?php
	}
	$statuses = __('plugin_invoice_statuses', true);
	$day_names = __('day_names', true);
	$months = __('months', true);
	ksort($day_names);
	ksort($months);
	?>
	<script type="text/javascript">
	var pjGrid = pjGrid || {};
	pjGrid.jqDateFormat = "<?php echo pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']); ?>";
	pjGrid.jsDateFormat = "<?php echo pjUtil::jsDateFormat($tpl['option_arr']['o_date_format']); ?>";
	var myLabel = myLabel || {};
	myLabel.uuid = "<?php __('booking_uuid', false, true); ?>";
	myLabel.client = "<?php __('booking_client', false, true); ?>";
	myLabel.created = "<?php __('booking_created', false, true); ?>";
	myLabel.status = "<?php __('booking_status', false, true); ?>";
	myLabel.total = "<?php __('booking_total', false, true); ?>";
	myLabel.statuses = <?php echo pjAppController::jsonEncode(__('booking_statuses', true)); ?>;
	myLabel.exported = "<?php __('lblExport', false, true); ?>";
	myLabel.delete_selected = "<?php __('delete_selected', false, true); ?>";
	myLabel.delete_confirmation = "<?php __('gridDeleteConfirmation', false, true); ?>";

	myLabel.num = "<?php __('plugin_invoice_i_num', false, true); ?>";
	myLabel.order_id = "<?php __('plugin_invoice_i_order_id', false, true); ?>";
	myLabel.issue_date = "<?php __('plugin_invoice_i_issue_date', false, true); ?>";
	myLabel.due_date = "<?php __('plugin_invoice_i_due_date', false, true); ?>";
	myLabel.created = "<?php __('plugin_invoice_i_created', false, true); ?>";
	myLabel.status = "<?php __('plugin_invoice_i_status', false, true); ?>";
	myLabel.total = "<?php __('plugin_invoice_i_total', false, true); ?>";
	myLabel.delete_title = "<?php __('plugin_invoice_i_delete_title', false, true); ?>";
	myLabel.delete_body = "<?php __('plugin_invoice_i_delete_body', false, true); ?>";
	myLabel.paid = "<?php echo $statuses['paid']; ?>";
	myLabel.not_paid = "<?php echo $statuses['not_paid']; ?>";
	myLabel.cancelled = "<?php echo $statuses['cancelled']; ?>";
	myLabel.empty_date = "<?php __('gridEmptyDate', false, true); ?>";
	myLabel.invalid_date = "<?php __('gridInvalidDate', false, true); ?>";
	myLabel.empty_datetime = "<?php __('gridEmptyDatetime', false, true); ?>";
	myLabel.invalid_datetime = "<?php __('gridInvalidDatetime', false, true); ?>";

	myLabel.monthNames = ["<?php echo join('","', $months); ?>"];
	myLabel.dayNamesMin = ["<?php echo join('","', $day_names); ?>"];
	myLabel.uuid_used = "<?php __('uuid_used', false, true); ?>";
	myLabel.services_required = "<?php __('services_required', false, true); ?>";
	</script>
	<?php
}
?>