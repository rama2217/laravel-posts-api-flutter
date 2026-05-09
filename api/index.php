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

// Copy packages.php dan services.php ke /tmp/bootstrap/cache
// karena Laravel butuh ini saat bootstrap
$filesToCopy = ['packages.php', 'services.php'];
foreach ($filesToCopy as $file) {
    $src = __DIR__ . '/../bootstrap/cache/' . $file;
    $dst = '/tmp/bootstrap/cache/' . $file;
    if (file_exists($src) && !file_exists($dst)) {
        copy($src, $dst);
    }
}

$_ENV['APP_STORAGE'] = '/tmp/storage';
putenv('APP_STORAGE=/tmp/storage');

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    $app->useStoragePath('/tmp/storage');

    // Override bootstrap cache path langsung
    $app->instance('path.bootstrap', '/tmp/bootstrap');

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
