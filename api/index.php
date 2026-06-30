<?php
// Forward request to Laravel public index

// Ensure the SQLite database file exists before Laravel boots
// (needed for Vercel serverless environment where /tmp is writable)
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
}

// Ensure /tmp/storage directories exist for Laravel
$dirs = [
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';
