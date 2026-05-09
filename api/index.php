<?php

$bootstrap = __DIR__ . '/../bootstrap/app.php';
$app = require $bootstrap;

var_dump(gettype($app));
var_dump($app);
exit;
