#!/usr/local/bin/php
<?php

/**
 * Timer.class example script
 * 
 * @author ktamas77 at gmail dot com
 */

error_reporting(E_ALL);

require_once 'timer.class.inc.php';

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
    for ($j = 0; $j < 1000000; $j++) $a = $i * $j;
    $timer->stop("subloop");
}

var_dump($timer->getAll());

?>
