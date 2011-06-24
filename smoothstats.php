<?php
/**
 * Provides Statistics methods. GetAdjustedAverage() - Calculate average of array element number values after excluding any elements that are above or below ($standardDeviationFactor * (standard deviation of $numberArray)
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
class SmoothStats{
	/**
	 * @var array An Array of numbers
	 */
	var $numberArray;
	
	/**
	 * @var int Count of $numArray elements
	 */
	var $count;
	
	/**
	 * @var float Mean of $numArray element values
	 */
	var $average;
	
	/**
	 * @var float Standard Deviation of $numArray element values
	 */
	var $deviation;
	
	/**
	 * @var number Factor representing how many multiples a $numberArray element can vary from the standards of deviation of the values of the array.
	 */
	var $standardDeviationFactor;
	
	/**
	 * @var float The maximum value an $numberArray element can be and still be included in final GetAdjustedAverage() average calculation
	 */
	var $limitMax;
	
	/**
	 * @var float The minimum value an $numberArray element can be and still be included in final GetAdjustedAverage() average calculation
	 */
	var $limitMin;
	
	/**
	 * Constructor.
	 * @param array $numberArray Array of numbers
	 * @return void
	 */
	public function __construct($numberArray){
		$this->numberArray = $numberArray;
		#$this->numberArray = array(7,7,7,7,7,7,7,7,7,9999);#44.3929
	}
	protected function Average($numberArray){
		$avg = null;
		if( is_array($numberArray) ){
			$sum   = array_sum($numberArray);
			$count = count($numberArray);
			if($count > 0){
				$avg = $sum/$count;
			}
		}
		return $avg;
	}
	protected function Deviation($numberArray){
		$deviation = null;
		if( is_array($numberArray) ){
			foreach ($numberArray as $num){
				$variance[] = pow($num - $this->average, 2);
			}
			$deviation = sqrt((array_sum($variance))/((count($numberArray))-1));
		}
		return $deviation;
	}
	protected function Round($val, $roundingPrecision){
		return round((float)$val, $roundingPrecision);
	}
	protected function GetNumberArrayElementsOutOfRangeRemoved($numberArray){
		$this->deviation = $this->Deviation($numberArray);
		$standardDeviationFactorCalc = $this->standardDeviationFactor;
		if($this->standardDeviationFactor == 0){
			$standardDeviationFactorCalc = 1;
		}
		$this->limitMax = (float)($this->average + ($standardDeviationFactorCalc * $this->deviation));
		$this->limitMin = (float)($this->average - ($standardDeviationFactorCalc * $this->deviation));
		$numberArrayProcessed = array();
		foreach ($numberArray as $num) {
			$num_f = (float)$num;
			if( ($num_f <= $this->limitMax) && ($num_f >= $this->limitMin)){
				$numberArrayProcessed[] = $num_f;
			}
		}
		return $numberArrayProcessed;
	}
	/**
	 * Calculate plain average
	 * @param int $roundingPrecision Optional Number of decimal places to round to. Default = -1 which causes output not be explicitly rounded.
	 * @return float
	 */
	public function GetAverage($roundingPrecision=-1){
		$this->average = $averageAdjusted = $this->Average($this->numberArray);
		if($roundingPrecision > -1){
			$averageAdjusted = $this->Round($this->average, $roundingPrecision);
		}
		return $averageAdjusted;
	}
	/**
	 * Calculate average of array element number values after excluding any elements that are above or below ($standardDeviationFactor * (standard deviation of $numberArray))
	 * @param number $standardDeviationFactor Optional Factor representing how many multiples a $numberArray element can vary from the standards of deviation of the values of the array. Default = 3
	 * @param int $roundingPrecision Optional Number of decimal places to round to. Default = -1 which causes output not be explicitly rounded.
	 * @return float
	 */
	public function GetAdjustedAverage($standardDeviationFactor=3, $roundingPrecision=-1){
		$this->standardDeviationFactor = $standardDeviationFactor;
		$averageAdjusted = 0;
		$numberArrayWithinRange = array();
		$this->count = count($this->numberArray);
		if($this->count > 0){
			$this->average = $this->Average($this->numberArray);
			$numberArrayWithinRange = $this->GetNumberArrayElementsOutOfRangeRemoved($this->numberArray);
			$averageAdjusted = $this->Average($numberArrayWithinRange);
			if($roundingPrecision > -1){
				$averageAdjusted = $this->Round($averageAdjusted, $roundingPrecision);
			}
		}
		return $averageAdjusted;
	}

}