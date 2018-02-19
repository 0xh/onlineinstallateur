<div class="pjIcCalendar">
	<div class="pj-calendar">
		<?php
		list($year, $month, $day) = explode("-", $_GET['date']);
		echo $tpl['calendar']->getWeekHTML(date("W",mktime(12, 0, 0, $month, $day, $year)),$year);
		?>
	</div>
</div>