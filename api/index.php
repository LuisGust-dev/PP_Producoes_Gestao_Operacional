<?php

$tmpDirectories = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
];

foreach ($tmpDirectories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$databasePath = '/tmp/database.sqlite';
$seedDatabasePath = __DIR__.'/../database/vercel.sqlite';

if (! file_exists($databasePath) && file_exists($seedDatabasePath)) {
    copy($seedDatabasePath, $databasePath);
}

require __DIR__.'/../public/index.php';
