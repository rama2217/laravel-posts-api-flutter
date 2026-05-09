<?php

// Load composer autoloader dulu
require __DIR__ . '/../vendor/autoload.php';

$bootstrap = __DIR__ . '/../bootstrap/app.php';
$app = require $bootstrap;

var_dump(gettype($app));
var_dump(get_class($app));
exit;
