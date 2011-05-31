<?php

require_once 'Tester.php'; 

$tests = array(
  'eval' => 'php',
  'unserialize' => 'phps',
  'json_decode' => 'json',
);

                              
$data = array();
foreach ($tests as $test) {
  include_once "data_{$test}.php";
}               


$tester = new Tester(1000);
$tester->setTestData($data);
$tester->setTests($tests);
$tester->runTests();
$tester->printResults();