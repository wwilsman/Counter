<?php

function Get( $k, $return = null )
{
	return ( isset($_GET[$k]) && !empty($_GET[$k]) ) ? $_GET[$k] : $return;
}

# Time format expects ISO 8601
$date = Get('date');

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

	$jsDate = "{$date['Y']}-{$date['m']}-{$date['d']}T{$date['H']}:{$date['i']}:{$date['s']}{$date['O']}";
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Count Down</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon-precomposed" href="counter-icon.png">
	<link rel="apple-touch-startup-image" href="counter-splash.png">
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="stylesheet" href="css/stylesheet.css">
</head>
<body>
	<div id="counter"></div>
	
	<script src="js/Counter.min.js"></script>
	<script>
		var cntElem = document.getElementById( 'counter' );
		var counter = new Counter( cntElem );
		counter.init( "<?php echo $jsDate;?>" );
	</script>
</body>
</html>