<?php

// Bridge ke Laravel public/index.php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files jika ada
if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

// Arahkan semua request ke Laravel
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';

require __DIR__ . '/../public/index.php';
