<?php

class Tester {
  
  private $_trys = 0;
  
  private $_data = array();
  
  private $_tests = array(
    'eval' => 'php',
    'unserialize' => 'phps',
    'json_decode' => 'json',
  );       
  
  private $_testsResults = array();
  
  function __construct($trys = 10) {
    $this->_trys = $trys;
    $this->_loadData();
  }                        
  
  private function _loadData() {
    $data = array();
    
    foreach ($this->_tests as $test) {
      include_once "data_{$test}.php";
    }                                 
    
    $this->setTestData($data);
  }                       
  
  public function setTestData(array $data) {
    $this->_data = $data;
  }                       
  
  public function runTests() {
    foreach ($this->_tests as $function => $dataKey) {
      $this->_testsResults[$dataKey] = $this->_runTest($function, $dataKey);
    }
  }  
  
  public function _runTest($function, $dataKey) {
    $testData = $this->_getTestData($dataKey);
    $testResult = array('function' => $function);
    
    $testTimes = array();
    for ($i=0; $i < $this->_trys; $i++) { 
      $testTime = $this->_testFunctionWithData($function, $testData);
      $testTimes[] = $testTime;
    }
    
    $testResult['times'] = $this->_calculateTimeMetricsFromResults($testTimes);                                           
    
    return $testResult;
  }                      
  
  private function _getTestData($dataKey) {
    return $this->_data[$dataKey];
  }
  
  private function _testFunctionWithData($function, $testData) {
    $testStart = microtime(true);              
    if ($function == 'eval') {
      eval('$testTemporaryResult = '.$testData.';');
    } else {
      $testTemporaryResult = call_user_func($function, $testData);
    }
    $testEnd = microtime(true);
    return $testEnd-$testStart;
  }         
  
  private function _calculateTimeMetricsFromResults($testTimes) {           
    return array(
      'min' => min($testTimes),
      'max' => max($testTimes),
      'avg' => array_sum($testTimes)/count($testTimes),
    );
  }       
  
  public function printResults() {
    echo "Test results({$this->_trys}):\n";
    foreach ($this->_testsResults as $result) {
      echo '- Test:', $result['function'], ' times: min:', $result['times']['min'], ' max:', $result['times']['max'], ' average: ', $result['times']['avg'], "\n";
    }
  }
}