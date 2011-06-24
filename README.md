#SmoothStats

A PHP class with main method GetAdjustedAverage(), used to calculate an average across $numberArray after excluding any number element that is above or below ($standardDeviationFactor * (standard deviation of $numberArray)).

## Usage Examples

### Usage Example - Plain Average

	$nums = array(6,6,6,6,7,7,7,7,8,8,8,8,999);
	$smoothstats = new SmoothStats($nums);
	$average = $smoothstats->GetAverage();
	
	Average: 83.307692307692
	

### Usage Example - Average with elements past standard deviation removed from calculation

	$nums = array(6,6,6,6,7,7,7,7,8,8,8,8,999);
	$smoothstats = new SmoothStats($nums);
	$average_sdf_3 = $smoothstats->GetAdjustedAverage($standardDeviationFactor=3, $roundingPrecision=2);
	
	Smoothed Average: 7

### SEE smoothstats.demo.php in a browser for examples and unit test results.