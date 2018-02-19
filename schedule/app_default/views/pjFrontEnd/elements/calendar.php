<div class="pjIcCalendar">
	<div class="pj-calendar">
		<?php
		list($year, $month,) = explode("-", $_GET['date']);
		echo $tpl['calendar']->getMonthHTML((int) $month, $year);
		?>
	</div>
</div>