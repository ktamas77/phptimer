#!/usr/local/bin/php
<?php

use ktamas77\phptimer\Timer;

/**
 * Timer example script
 *
 * @author Tamas Kalman <ktamas77@gmail.com>
 */

date_default_timezone_set('UTC');
error_reporting(E_ALL);

$timer = new Timer();

$a = 0;

$timer->start('cycle');
for ($i = 0; $i < 100000; $i++) {
    $a *= $i;
}
$timer->stop('cycle');

$timer->start('date');
for ($i = 0; $i < 10000; $i++) {
    $d = date("Y-m-d H:i");
}
$timer->stop('date');

for ($i = 0; $i < 10; $i++) {
    $timer->start("subloop");
    for ($j = 0; $j < 1000000; $j++) {
        $a = $i * $j;
    }
    $timer->stop("subloop");
}

var_dump($timer->getAll());
