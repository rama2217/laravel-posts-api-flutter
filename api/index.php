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
    $app->useStoragePath('/tmp/storage');

    // Cek path yang dipakai Laravel
    echo json_encode([
        'storage_path' => $app->storagePath(),
        'bootstrap_path' => $app->bootstrapPath(),
        'cache_path' => $app->bootstrapPath('cache'),
        'writable_storage' => is_writable('/tmp/storage'),
        'writable_bootstrap' => is_writable('/tmp/bootstrap/cache'),
    ]);
} catch (\Throwable $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
