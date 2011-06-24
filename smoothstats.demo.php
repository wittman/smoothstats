<?php
/**
 * Unit Test of Smooth Stats
 * 
 * @copyright  Copyright (c) 2009 Micah Wittman
 * @author	 Micah Wittman <smoothstats.m@wittman.org>
 * @license	http://wittman.org/projects/smoothstats/license.txt
 * 
 * @package	SmoothStats
 * @link	   http://wittman.org/projects/smoothstats/
 * 
 * @version	0.1
 */

include 'smoothstats.php';
include 'smoothstats.test.php';

//Run Tests
$testSmoothStats = new TestSmoothStats();


//Usage Example:
$nums = array(6,6,6,6,7,7,7,7,8,8,8,8,999);
$smoothstats = new SmoothStats($nums);
$average = $smoothstats->GetAverage();
$average_sdf_3 = $smoothstats->GetAdjustedAverage($standardDeviationFactor=1, $roundingPrecision=2);
?>
<!DOCTYPE html>  
<html lang="en">  
	<head>
		<meta charset="utf-8">
		<title>SmoothStats Examples and Unit Test Results</title>
	</head>  
	<body> 

		<h1>Usage Examples</h1>
		
		<h2>Usage Example - Plain Average</h1> 
		<pre><code>
			$nums = array(6,6,6,6,7,7,7,7,8,8,8,8,999);<br>
			$smoothstats = new SmoothStats($nums);<br>
			$average = $smoothstats->GetAverage();<br>
			Average: <strong><?php echo $average; ?></strong>
		</code></pre>
		
		<h2>Usage Example - Average with elements past standard deviation removed from calculation</h1> 
		<pre><code>
			$nums = array(6,6,6,6,7,7,7,7,8,8,8,8,999);<br>
			$smoothstats = new SmoothStats($nums);<br>
			$average_sdf_3 = $smoothstats->GetAdjustedAverage($standardDeviationFactor=3, $roundingPrecision=2);<br>
			Smoothed Average: <strong><?php echo $average_sdf_3; ?></strong>
		</code></pre>
	
		<h1>Unit Tests</h1> 
		<p>
			<?php $testSmoothStats->Run(); ?>
		</p>

		
	</body>
</html>