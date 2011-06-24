<?php
/**
 * Test class for SmoothStats
 * 
 * @copyright  Copyright (c) 2009 Micah Wittman
 * @author	 Micah Wittman <smoothstats.m@wittman.org>
 * @license	http://wittman.org/projects/smoothstats/license.txt
 * 
 * @package	SmoothStats Test
 * @link	   http://wittman.org/projects/smoothstats/
 * 
 * @version	0.1
 */

class TestSmoothStats{
	/**
	 * @var string Test Name
	 */
	var $testName;
	
	/**
	 * @var bool TRUE if test passed
	 */
	var $passed;
	
	/**
	 * @var mixed Expected test value
	 */
	var $expectedVal;
	
	/**
	 * @var mixed Actual test value
	 */
	var $actualVal;
	
	public function __construct(){
		//
	}
	private function Test1(){
		$pass = false;
		$numArray = array(6,6,6,6,7,7,7,7,8,8,8,8);
		$expectedVal = 7;
		
		$smoothstats = new SmoothStats($numArray);
		
		$actualVal = $smoothstats->GetAdjustedAverage();
		
		$passed = ($actualVal == $expectedVal) ? true : false;
		
		$this->testName = 'Test1';
		$this->passed = $passed;
		$this->expectedVal = $expectedVal;
		$this->actualVal = $actualVal;
		return $this->TestResult();
	}
	private function Test2(){
		$pass = false;
		$numArray = array(6,6,6,6,7,7,7,7,8,8,8,8,999);
		$expectedVal = 7;
		
		$smoothstats = new SmoothStats($numArray);
		
		$actualVal = $smoothstats->GetAdjustedAverage();
		
		$passed = ($actualVal == $expectedVal) ? true : false;
		
		$this->testName = 'Test2';
		$this->passed = $passed;
		$this->expectedVal = $expectedVal;
		$this->actualVal = $actualVal;
		return $this->TestResult();
	}
	private function Test3(){
		$pass = false;
		$numArray = array(6,7,999);
		$expectedVal = 337.33;
		
		$smoothstats = new SmoothStats($numArray);
		
		$actualVal = $smoothstats->GetAdjustedAverage($standardDeviationFactor=3, $roundingPrecision=2);
		
		$passed = ($actualVal == $expectedVal) ? true : false;
		
		$this->testName = 'Test3';
		$this->passed = $passed;
		$this->expectedVal = $expectedVal;
		$this->actualVal = $actualVal;
		return $this->TestResult();
	}
	private function Test4(){
		$pass = false;
		$numArray = array(6,6,6,6,7,7,7,7,8,8,8,8,999);
		$expectedVal = 83.308;
		
		$smoothstats = new SmoothStats($numArray);
		
		$actualVal = $smoothstats->GetAdjustedAverage($standardDeviationFactor=4, $roundingPrecision=3);
		
		$passed = ($actualVal == $expectedVal) ? true : false;
		
		$this->testName = 'Test4';
		$this->passed = $passed;
		$this->expectedVal = $expectedVal;
		$this->actualVal = $actualVal;
		return $this->TestResult();
	}
	private function TestResult(){
		if($this->passed){
			return sprintf('<div style="margin:1.5em;color:green"><strong>%s</strong> <strong>Passed</strong> (Matching Value: %s)</div>', $this->testName, $this->actualVal);
		}else{
			return sprintf('<div style="margin:1.5em;color:red"><strong>%s</strong> <strong>FAILED!</strong> (Expected: %s) (Actual: %s)</div>', $this->testName, $this->expectedVal, $this->actualVal);
		}
	}
	public function Run(){
		//Test1: For default $standardDeviationFactor = 3, the simple average and the adjusted average for array values (6,6,6,6,7,7,7,7,8,8,8,8)
		// should be the same: 7. No element is remotely close to being out by a factor of 3 times the standard deviation.
		echo $this->Test1();
		
		
		//Test2: For default $standardDeviationFactor = 3, the adjusted average for array values (6,6,6,6,7,7,7,7,8,8,8,8,999)
		// should still be: 7. Notice the simple average to the second decimal place is: 83.31.
		// The adjusted average dropped the 999 element because it exceeded the maximum limit of average + 3 times the standard deviation
		// for this set of numbers.
		echo $this->Test2();
		
		//Test3: For default $standardDeviationFactor = 3, the simple average and the adjusted average for array values (6,7,999)
		// with $roundingPrecision=3, should be the same: 83.308. With only three elements, the standard deviation can't determine which value is the anamoly.
		echo $this->Test3();
		
		//Test4: If $standardDeviationFactor = 4, then 999 in series (6,6,6,6,7,7,7,7,8,8,8,8,999) should be included in mean calculation
		echo $this->Test4();
	}
}
?>