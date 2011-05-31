<?php

require_once 'Tester.php';

$tester = new Tester(1000);
$tester->runTests();
$tester->printResults();