<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Fix untuk Vercel read-only filesystem
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

// Copy bootstrap cache files ke /tmp jika ada
$cacheFiles = glob(__DIR__ . '/../bootstrap/cache/*.php');
foreach ($cacheFiles as $file) {
    $dest = '/tmp/bootstrap/cache/' . basename($file);
    if (!file_exists($dest)) {
        copy($file, $dest);
    }
}

$_ENV['APP_STORAGE'] = '/tmp/storage';
putenv('APP_STORAGE=/tmp/storage');

// Load composer autoloader
require __DIR__ . '/../vendor/autoload.php';

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

chdir(__DIR__ . '/../public');

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<pre>";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "</pre>";
}
