PHPTimer
========

An easy to use 100% native PHP library to profile PHP code.

You can start/stop timers at any point in the code.

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
