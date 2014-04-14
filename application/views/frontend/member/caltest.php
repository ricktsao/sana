	<style type="text/css">
		.calendar {
			font-family: Arial; font-size: 12px;
		}
		table.calendar {
			margin: auto; border-collapse: collapse;
		}
		.calendar .days td {
			width: 280px; height:50px; padding: 5px;
			border: 1px solid #999;
			vertical-align: middle;
			background-color: #f8f8f8;
		}
		.calendar .days td:hover {
			background-color: #FFF;
		}
		.calendar .highlight {
			font-weight: bold; color: #00F;
		}
	</style>
	<div id='calendar' style='padding:30px 0'>
	<?php
	echo $cal;
	?>
	</div>