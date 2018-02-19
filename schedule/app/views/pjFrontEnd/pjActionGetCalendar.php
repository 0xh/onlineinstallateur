<div class="pjIcCalendar">
	<div class="pj-calendar">
		<?php
		echo $tpl['calendar']->getWeekHTML($_GET['month'], $_GET['year']);
		?>
	</div><!-- /.pj-calendar -->
</div>