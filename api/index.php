<?php

error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', getenv('APP_DEBUG') === 'true' ? '1' : '0');
ini_set('display_startup_errors', getenv('APP_DEBUG') === 'true' ? '1' : '0');

register_shutdown_function(function (): void {
    $error = error_get_last();

    if ($error !== null) {
        error_log('VERCEL_FATAL: '.json_encode($error));
    }
});

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

if (($_SERVER['REQUEST_URI'] ?? '') === '/__vercel-diagnostics') {
    header('Content-Type: application/json');

    echo json_encode([
        'app_key' => getenv('APP_KEY') ? 'set' : 'missing',
        'app_debug' => getenv('APP_DEBUG') ?: null,
        'db_connection' => getenv('DB_CONNECTION') ?: null,
        'db_database' => getenv('DB_DATABASE') ?: null,
        'database_exists' => file_exists($databasePath),
        'database_writable' => file_exists($databasePath) && is_writable($databasePath),
        'seed_database_exists' => file_exists($seedDatabasePath),
        'vendor_exists' => file_exists(__DIR__.'/../vendor/autoload.php'),
        'public_index_exists' => file_exists(__DIR__.'/../public/index.php'),
        'views_path_writable' => is_writable('/tmp/views'),
    ]);

    return;
}

try {
    require __DIR__.'/../public/index.php';
} catch (Throwable $exception) {
    error_log('VERCEL_EXCEPTION: '.$exception::class.' - '.$exception->getMessage());
    error_log($exception->getTraceAsString());

    throw $exception;
}
