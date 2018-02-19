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
	pjUtil::printNotice(@$titles['AS10'], @$bodies['AS10']);
	
	if (isset($_GET['err']))
	{
		pjUtil::printNotice(@$titles[$_GET['err']], @$bodies[$_GET['err']]);
	}
	?>
	<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
	<div class="multilang"></div>
	<?php endif; ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminServices&amp;action=pjActionUpdate" method="post" id="frmUpdateService" class="form pj-form" enctype="multipart/form-data" >
		<input type="hidden" name="service_update" value="1" />
		<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
		<?php
		foreach ($tpl['lp_arr'] as $v)
		{
		?>
			<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
				<label class="title"><?php __('service_name'); ?>:</label>
				<span class="inline_block">
					<input type="text" name="i18n[<?php echo $v['id']; ?>][name]" class="pj-form-field w400<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" value="<?php echo pjSanitize::html($tpl['arr']['i18n'][$v['id']]['name']); ?>" />
					<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
					<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
					<?php endif; ?>
				</span>
			</p>
			<?php
		}
		foreach ($tpl['lp_arr'] as $v)
		{
		?>
			<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
				<label class="title"><?php __('service_desc'); ?>:</label>
				<span class="inline_block">
					<textarea name="i18n[<?php echo $v['id']; ?>][description]" class="pj-form-field w500 h150"><?php echo pjSanitize::html($tpl['arr']['i18n'][$v['id']]['description']); ?></textarea>
					<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
					<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
					<?php endif; ?>
				</span>
			</p>
			<?php
		}
		?>
		<p>
			<label class="title"><?php __('service_price'); ?></label>
			<span class="pj-form-field-custom pj-form-field-custom-before">
				<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
				<input type="text" name="price" id="price" class="pj-form-field required number w70 align_right" value="<?php echo number_format($tpl['arr']['price'], 2, ".", ""); ?>" />
			</span>
		</p>
		<p>
			<label class="title"><?php __('service_image'); ?></label>
			<span class="float_left block">
				<?php
				if (!empty($tpl['arr']['image']) && is_file($tpl['arr']['image']))
				{
					?>
					<span class="boxImage">
						<img src="<?php echo PJ_INSTALL_URL . $tpl['arr']['image']; ?>?<?php echo rand(1, 9999); ?>" alt="" /><br />
						<input type="button" value="<?php __('employee_avatar_delete'); ?>" class="pj-button b5 t5 btnDeleteImage" /><br />
					</span>
					<span class="boxNoImage" style="display: none"><img src="<?php echo PJ_INSTALL_URL . PJ_IMG_PATH; ?>backend/service.gif" alt="" /><br /></span>
					<?php
				} else {
					?><img src="<?php echo PJ_INSTALL_URL . PJ_IMG_PATH; ?>backend/service.gif" alt="" /><br /><?php
				}
				?>
				<input type="file" name="image" id="image" />
			</span>
		</p>
		<p>
			<label class="title"><?php __('service_length'); ?></label>
			<span class="inline_block">
				<input type="text" name="length" id="length" class="pj-form-field required number w80 spinner" value="<?php echo (int) $tpl['arr']['length']; ?>" />
				<a href="#" class="pj-form-langbar-tip listing-tip" original-title="<?php __('service_tip_length', false, true); ?>"></a>
			</span>
		</p>
		<p>
			<label class="title"><?php __('service_before'); ?></label>
			<span class="inline_block">
				<input type="text" name="before" id="before" class="pj-form-field required number w80 spinner" value="<?php echo (int) $tpl['arr']['before']; ?>" />
				<a href="#" class="pj-form-langbar-tip listing-tip" original-title="<?php __('service_tip_before', false, true); ?>"></a>
			</span>
		</p>
		<p>
			<label class="title"><?php __('service_after'); ?></label>
			<span class="inline_block">
				<input type="text" name="after" id="after" class="pj-form-field required number w80 spinner" value="<?php echo (int) $tpl['arr']['after']; ?>" />
				<a href="#" class="pj-form-langbar-tip listing-tip" original-title="<?php __('service_tip_after', false, true); ?>"></a>
			</span>
		</p>
		<p>
			<label class="title"><?php __('service_total'); ?></label>
			<span id="print_total" class="left"><?php echo (int) $tpl['arr']['total']; ?></span>
			<input type="hidden" name="total" id="total" class="required number" value="<?php echo (int) $tpl['arr']['total']; ?>" />
		</p>
		<p>
			<label class="title"><?php __('service_status'); ?></label>
			<span class="inline_block">
				<select name="is_active" id="is_active" class="pj-form-field required">
					<option value="">-- <?php __('lblChoose'); ?>--</option>
					<?php
					foreach (__('is_active', true) as $k => $v)
					{
						?><option value="<?php echo $k; ?>"<?php echo $k == $tpl['arr']['is_active'] ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
					}
					?>
				</select>
			</span>
		</p>
		<p>
			<label class="title"><?php __('service_employees'); ?></label>
			<span class="inline_block">
				<select name="employee_id[]" class="pj-form-field" multiple>
					<?php
					foreach ($tpl['employee_arr'] as $employee)
					{
						?><option value="<?php echo $employee['id']; ?>"<?php echo in_array($employee['id'], $tpl['es_arr']) ? ' selected="selected"' : NULL; ?>><?php echo pjSanitize::html($employee['name']); ?></option><?php
					}
					?>
				</select>
				<a href="#" class="pj-form-langbar-tip listing-tip" original-title="<?php __('service_tip_employees', false, true); ?>"></a>
			</span>
		</p>
		<p>
			<label class="title">&nbsp;</label>
			<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button" />
			<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminServices&action=pjActionIndex';" />
		</p>
	</form>
	<div id="dialogDeleteImage" title="<?php __('employee_avatar_dtitle'); ?>" style="display: none"><?php __('employee_avatar_dbody'); ?></div>
	<script type="text/javascript">
	var myLabel = myLabel || {};
	myLabel.checkAllText = "<?php __('multiselect_check_all', false, true); ?>";
	myLabel.uncheckAllText = "<?php __('multiselect_uncheck_all', false, true); ?>";
	myLabel.noneSelectedText = "<?php __('multiselect_none_selected', false, true); ?>";
	myLabel.selectedText = "<?php __('multiselect_selected', false, true); ?>";
	myLabel.positiveNumber = "<?php __('positive_number', false, true); ?>";
	
	<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
	var pjLocale = pjLocale || {};
	pjLocale.langs = <?php echo $tpl['locale_str']; ?>;
	pjLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
	(function ($) {
		$(function() {
			$(".multilang").multilang({
				langs: pjLocale.langs,
				flagPath: pjLocale.flagPath,
				tooltip: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sit amet faucibus enim.",
				select: function (event, ui) {
					// Callback, e.g. ajax requests or whatever
				}
			});
		});
	})(jQuery_1_8_2);
	<?php endif; ?>
	</script>
	<?php
}
?>