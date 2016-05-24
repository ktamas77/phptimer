PHPTimer
========

An easy to use 100% native PHP library to profile PHP code.

You can start/stop timers at any point in the code.

```php

  require_once 'timer.class.inc.php';
  
  $timer = new Timer();
  
  $timer->start('cycle');
  for ($i = 0; $i < 100000; $i++) {
    $a *= $i;
  }
  $timer->stop('cycle');
  
  for ($i = 0; $i < 10; $i++) {
    $timer->start("subloop");
    for ($j = 0; $j < 1000000; $j++) $a = $i * $j;
    $timer->stop("subloop");
  }  
  
  var_dump($timer->getAll());
```

Result:

```
php timer_example.php 

array(3) {
  ["cycle"]=>
  array(8) {
    ["start"]=>
    float(1464109111.9151)
    ["stop"]=>
    float(1464109111.9188)
    ["starts"]=>
    int(1)
    ["range"]=>
    float(0.0037481784820557)
    ["status"]=>
    string(7) "stopped"
    ["average"]=>
    float(0.0037481784820557)
    ["average_human"]=>
    string(4) "0.00"
    ["range_human"]=>
    string(4) "0.00"
  }
  ["date"]=>
  array(8) {
    ["start"]=>
    float(1464109111.9189)
    ["stop"]=>
    float(1464109112.2928)
    ["starts"]=>
    int(1)
    ["range"]=>
    float(0.37390089035034)
    ["status"]=>
    string(7) "stopped"
    ["average"]=>
    float(0.37390089035034)
    ["average_human"]=>
    string(4) "0.37"
    ["range_human"]=>
    string(4) "0.37"
  }
  ["subloop"]=>
  array(8) {
    ["start"]=>
    float(1464109112.5907)
    ["stop"]=>
    float(1464109112.6227)
    ["starts"]=>
    int(10)
    ["range"]=>
    float(0.32978487014771)
    ["status"]=>
    string(7) "stopped"
    ["average"]=>
    float(0.032978487014771)
    ["average_human"]=>
    string(4) "0.03"
    ["range_human"]=>
    string(4) "0.33"
  }
}
```