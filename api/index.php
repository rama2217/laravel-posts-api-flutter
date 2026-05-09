<?php

$dirs = [
    '/tmp/storage/logs',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/testing',
    '/tmp/storage/app/public',
    '/tmp/bootstrap',
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

// Patch PackageManifest sebelum app dibuat
// dengan symlink bootstrap/cache ke /tmp/bootstrap/cache
$originalCache = __DIR__ . '/../bootstrap/cache';
if (!is_link($originalCache) && !is_writable($originalCache)) {
    // Buat symlink dari bootstrap/cache ke /tmp/bootstrap/cache
    @symlink('/tmp/bootstrap/cache', $originalCache);
}

try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    $app->useStoragePath('/tmp/storage');

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);

    $response->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
