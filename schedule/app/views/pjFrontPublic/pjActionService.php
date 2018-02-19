<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="panel panel-default pjAsContainer pjAsAside">
				<div class="panel-heading pjAsHead">
					<h2 class="pjAsHeadTitle">Planen Sie Ihren Termin</h2><!-- /.pjAsHeadTitle -->
                    <h4>Wählen Sie 3 bevorzugte Termine</h4>
                     <p style="text-transform: none;">Unser Mitarbeiter wird Ihnen einen Termin innerhalb 24 Stunden per E-mail bestätigen.</p>
				</div><!-- /.panel-heading pjAsHead -->

				<div class="panel-body pjAsCalendarInline">
					<?php include PJ_VIEWS_PATH . 'pjFrontEnd/elements/calendar.php'; ?>
				</div><!-- /.panel-body pjAsCalendarInline -->

				<ul id="pjAsAsideCart" class="list-group pjAsAsideServices">
					<?php
					$cart = $controller->cart->getAll();
					$cart_arr = $tpl['cart_arr'];
					include PJ_VIEWS_PATH . 'pjFrontPublic/elements/cart_layout2.php';
					?>
				</ul><!-- /.list-group pjAsAsideServices -->
                
                
			</div><!-- /.panel panel-default pjAsContainer pjAsAside -->
		</div><!-- /.col-lg-4 col-md-4 col-sm-12 col-xs-12 -->


	</div><!-- /.row -->
</div><!-- /.container-fluid -->