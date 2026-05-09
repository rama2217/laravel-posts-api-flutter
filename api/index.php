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

$originalCache = __DIR__ . '/../bootstrap/cache';
$symlinkResult = @symlink('/tmp/bootstrap/cache', $originalCache);

echo json_encode([
    'symlink_result' => $symlinkResult,
    'is_link' => is_link($originalCache),
    'is_writable' => is_writable($originalCache),
    'original_cache' => $originalCache,
    'tmp_writable' => is_writable('/tmp/bootstrap/cache'),
]);
