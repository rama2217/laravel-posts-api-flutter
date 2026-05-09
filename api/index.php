<?php

$dirs = [
    '/tmp/storage/logs',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/testing',
    '/tmp/storage/app/public',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

$_ENV['APP_STORAGE'] = '/tmp/storage';
putenv('APP_STORAGE=/tmp/storage');

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    echo json_encode(['status' => 'bootstrap ok', 'app' => get_class($app)]);
} catch (\Throwable $e) {
    echo json_encode(['error' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
}
