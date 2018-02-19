<?php
if (isset($tpl['status']) && $tpl['status'] == "OK")
{
	?>
	<div class="panel-heading pjAsHead">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-warning" role="alert">
					<?php __('front_system_msg'); ?><br/>
					<?php
					$status = __('front_booking_status', true);
					if (isset($tpl['booking_arr']))
					{
						switch ($tpl['booking_arr']['payment_method'])
						{
							case 'paypal':
								switch ($tpl['invoice_arr']['status'])
								{
									case 'not_paid':
								
										echo $status[11];
										?>
										<div class="asElementOutline"><?php
										if (pjObject::getPlugin('pjPaypal') !== NULL)
										{
											$controller->requestAction(array('controller' => 'pjPaypal', 'action' => 'pjActionForm', 'params' => $tpl['params']));
										}
										?></div><?php
										break;
									case 'cancelled':
										echo $status[5];
										break;
									default:
										echo $status[3];
										break;
								}
								break;
							case 'authorize':
								switch ($tpl['invoice_arr']['status'])
								{
									case 'not_paid':
										echo $status[11];
										?>
										<div class="asElementOutline"><?php
										if (pjObject::getPlugin('pjAuthorize') !== NULL)
										{
											$controller->requestAction(array('controller' => 'pjAuthorize', 'action' => 'pjActionForm', 'params' => $tpl['params']));
										}
										?></div><?php
										break;
									case 'cancelled':
										echo $status[5];
										break;
									default:
										echo $status[3];
										break;
								}
								break;
							case 'bank':
								echo $status[1] . '<br/>' .  pjSanitize::html(nl2br($tpl['option_arr']['o_bank_account']));
								?><br/><a href="#" class="alert-link pjAsBtnBackToServices"><?php __('front_start_over');?></a><?php 
								break;
							case 'creditcard':
							case 'none':
							default:
								echo $status[1];
								?><br/><a href="#" class="alert-link pjAsBtnBackToServices"><?php __('front_start_over');?></a><?php
						}
					} else {
						echo $status[4];
					}
					?>
				</div>
			</div><!-- /.col-lg-12 col-md-12 col-sm-12 col-xs-12 -->
		</div>
	</div>
	<?php
} elseif (isset($tpl['status']) && $tpl['status'] == 'ERR') {
	?>
	<div class="panel-heading pjAsHead">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-warning" role="alert">
				  	<?php __('front_system_msg'); ?><br/><?php __('front_checkout_na'); ?><br/><a href="#" class="alert-link pjAsBtnBackToServices"><?php __('front_return_back');?></a>
				</div>
			</div><!-- /.col-lg-12 col-md-12 col-sm-12 col-xs-12 -->
		</div><!-- /.row -->
	</div><!-- /.panel-heading pjAsHead -->
	<?php
}
?>