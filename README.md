PHPTimer
========

> Note: v2.0.0 requires PHP 7.3 and using its own namespace.
>
> For PHP 5 projects please use v1.0.0

An easy to use 100% native PHP library to profile PHP code.

You can start/stop timers at any point in the code.

#### v2.0.0 use for PHP 7.3+:

Installation:

```bash
composer require ktamas77/phptimer
```

Use in code:


```php
use ktamas77\phptimer\Timer;
```

#### v1.0.0 (legacy) use for PHP 5:

Installation: 

```bash
composer require ktamas77/phptimer:1.0.0
```

Use in code:


```php
<php

require_once 'timer.class.inc.php';
```  
  
### Example use:
  
```php
$timer = new Timer();

$timer->start('cycle');
    for ($i = 0; $i < 100000; $i++) {
    $a *= $i;
}
$timer->stop('cycle');

for ($i = 0; $i < 10; $i++) {
    $timer->start("subloop");
    for ($j = 0; $j < 1000000; $j++) {
        $a = $i * $j;
    }
    $timer->stop("subloop");
}  

var_dump($timer->getAll());
```

Result:

```bash
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
