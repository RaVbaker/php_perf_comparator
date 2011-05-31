# PHP perf comparator
        
Simple class for testing performance of functions.

## Example of usage

You can find in file test.php

  $tester = new Tester(1000);
  $tester->setTestData($data);
  $tester->setTests($tests);
  $tester->runTests();
  $tester->printResults();
  
## About:

Author: Rafal "RaVbaker" Piekarski
Version: 0.01

## TODOS:

- write some PHPUnits
