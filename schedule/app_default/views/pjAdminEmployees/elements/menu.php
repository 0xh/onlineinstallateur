<?php
$active = " ui-tabs-active ui-state-active";
?>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminEmployees' || $_GET['action'] != 'pjActionIndex' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminEmployees&amp;action=pjActionIndex"><?php __('menuEmployees'); ?></a></li>
		<?php
		if (($_GET['controller'] == 'pjAdminEmployees' && $_GET['action'] == 'pjActionUpdate' && isset($_GET['id'])) ||
			($_GET['controller'] == 'pjAdminTime' && isset($_GET['foreign_id']))
		)
		{
			?><li class="ui-state-default ui-corner-top<?php echo $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminEmployees&amp;action=pjActionUpdate&amp;id=<?php echo $employee_id; ?>"><?php __('employee_update'); ?></a></li><?php
		}
		?>
	</ul>
</div>