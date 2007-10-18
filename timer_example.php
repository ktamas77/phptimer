#!/usr/local/bin/php
<?

// --- Timer.class example script
// --- author: dh at squidcode dot com
// --- web: http://dh.squidcode.com

error_reporting (E_ALL);

require_once ('timer.class.inc.php');

$timer = new Timer();

$timer->start('cycle');
for ($i=0;$i<1000000;$i++) $a *= i;
$timer->stop('cycle');

$timer->start ('date');
for ($i=0;$i<1000000;$i++) $d = date ("Y-m-d H:i");
$timer->stop ('date');

var_dump ($timer->getAll());

?>
