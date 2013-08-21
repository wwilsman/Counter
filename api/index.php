<?php

function Get( $k, $return = null )
{
	return ( isset($_GET[$k]) && !empty($_GET[$k]) ) ? $_GET[$k] : $return;
}
function addOmittedClasses( $omit )
{
	$c = '';
	if( in_array('d', $omit) ) $c = $c . ' no-days';
	if( in_array('H', $omit) ) $c = $c . ' no-hours';
	if( in_array('i', $omit) ) $c = $c . ' no-minutes';
	if( in_array('s', $omit) ) $c = $c . ' no-seconds';
	if( in_array('u', $omit) ) $c = $c . ' no-millisecs';
	return $c;
}

# Time Format Expects ISO8601
$date = Get('date', Get('d'));
# List of Values to Omit to Array
$omit = str_split(Get('omit', Get('o')));
# Get BG Color (YET TO IMPLIMENT)
$color = '#' . Get('color', Get('c'));

# Check for Date and Time
if( preg_match('/^
	(					# Date (1) 
		([\d]{4})-?		# Year (2)
		([\d]{2})?-?	# Month (3)
		([\d]{2})?		# Day (4)
	)?T?(				# Time (5) 
		([\d]{2}):?		# Hours (6)
		([\d]{2})?:?	# Minutes (7)
		([\d]{2})?		# Seconds (8)
	)?([\+\-][\d]{4})?	# Timezone (9)
	$/x', $date, $regs) )
{
	# Build the Date, Substituting Where Values are not Given
	$date = array(
		'Y' => !empty($regs[2]) ? $regs[2] : date('Y'),
		'm' => !empty($regs[3]) ? $regs[3] : '01',
		'd' => !empty($regs[4]) ? $regs[4] : '01',
		'H' => !empty($regs[6]) ? $regs[6] : '00',
		'i' => !empty($regs[7]) ? $regs[7] : '00',
		's' => !empty($regs[8]) ? $regs[8] : '00',
		'O' => !empty($regs[9]) ? $regs[9] : date('O')
	);

	$jsDate = "{$date['Y']}/{$date['m']}/{$date['d']} {$date['H']}:{$date['i']}:{$date['s']}{$date['O']}";
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Count Down</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="stylesheet" href="css/stylesheet.css">
	
	<script src="Counter.min.js"></script>
</head>
<body>
	<div id="counter">
		<div class="cnt_container <?php echo addOmittedClasses($omit);?>">
			<div class="cnt_days">
				<div class="cnt_number" id="days"></div>
				<div class="cnt_label"></div>
			</div><!--
		 --><div class="wrapper">
				<div class="cnt_hours">
					<div class="cnt_number" id="hours"></div>
					<div class="cnt_label"></div>
				</div><!--
			 --><div class="cnt_minutes">
					<div class="cnt_number" id="minutes"></div>
					<div class="cnt_label"></div>
				</div>
			</div><!--
		 --><div class="wrapper">
				<div class="cnt_seconds">
					<div class="cnt_number" id="seconds"></div>
					<div class="cnt_label"></div>
				</div><!--
			 --><div class="cnt_millisecs">
					<div class="cnt_number" id="millisecs"></div>
					<div class="cnt_label"></div>
				</div>
			</div>
		</div>
	</div>
	
<?php 
	echo "<script>";
		echo "var counter = new Counter({";
			echo "date: '$jsDate'";
		if( !in_array('d', $omit) )
			echo ", days: document.getElementById('days')";
		if( !in_array('H', $omit) )
			echo ", hours: document.getElementById('hours')";
		if( !in_array('i', $omit) )
			echo ", minutes: document.getElementById('minutes')";
		if( !in_array('s', $omit) )
			echo ", seconds: document.getElementById('seconds')";
		if( !in_array('u', $omit) )
			echo ", millisecs: document.getElementById('millisecs')";
		echo "}).init();";
	echo "</script>";
?>
</body>
</html>