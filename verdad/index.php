<?php

//server command: php -S localhost:8088 -t .

$f3 = require('app/lib/base.php');
$f3 = Base::instance();

$f3->config('config.ini');
$f3->config('routes.ini');

$f3->run();
?>