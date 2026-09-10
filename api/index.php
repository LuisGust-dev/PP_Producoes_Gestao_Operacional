<?php

error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', getenv('APP_DEBUG') === 'true' ? '1' : '0');
ini_set('display_startup_errors', getenv('APP_DEBUG') === 'true' ? '1' : '0');

putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

putenv('LOG_STACK=stderr');
$_ENV['LOG_STACK'] = 'stderr';
$_SERVER['LOG_STACK'] = 'stderr';

putenv('APP_MAINTENANCE_DRIVER=array');
$_ENV['APP_MAINTENANCE_DRIVER'] = 'array';
$_SERVER['APP_MAINTENANCE_DRIVER'] = 'array';

putenv('APP_MAINTENANCE_STORE=array');
$_ENV['APP_MAINTENANCE_STORE'] = 'array';
$_SERVER['APP_MAINTENANCE_STORE'] = 'array';

putenv('SESSION_DRIVER=database');
$_ENV['SESSION_DRIVER'] = 'database';
$_SERVER['SESSION_DRIVER'] = 'database';

putenv('SESSION_CONNECTION=sqlite');
$_ENV['SESSION_CONNECTION'] = 'sqlite';
$_SERVER['SESSION_CONNECTION'] = 'sqlite';

putenv('SESSION_SECURE_COOKIE=true');
$_ENV['SESSION_SECURE_COOKIE'] = 'true';
$_SERVER['SESSION_SECURE_COOKIE'] = 'true';

putenv('SESSION_SAME_SITE=lax');
$_ENV['SESSION_SAME_SITE'] = 'lax';
$_SERVER['SESSION_SAME_SITE'] = 'lax';

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
    '/tmp/logs',
    '/tmp/framework',
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
        'session_driver' => getenv('SESSION_DRIVER') ?: null,
        'session_secure_cookie' => getenv('SESSION_SECURE_COOKIE') ?: null,
        'session_same_site' => getenv('SESSION_SAME_SITE') ?: null,
    ]);

    return;
}

if (($_SERVER['REQUEST_URI'] ?? '') === '/__laravel-diagnostics') {
    header('Content-Type: application/json');

    try {
        $logPath = '/tmp/logs/laravel.log';

        if (file_exists($logPath)) {
            unlink($logPath);
        }

        define('LARAVEL_START', microtime(true));

        require __DIR__.'/../vendor/autoload.php';

        $app = require_once __DIR__.'/../bootstrap/app.php';
        $response = $app->handle(Illuminate\Http\Request::create('/login', 'GET'));

        echo json_encode([
            'status' => $response->getStatusCode(),
            'manifest_exists' => file_exists(__DIR__.'/../public/build/manifest.json'),
            'content_preview' => substr($response->getContent(), 0, 1000),
            'log_tail' => file_exists($logPath) ? substr(file_get_contents($logPath), -4000) : null,
        ]);
    } catch (Throwable $exception) {
        echo json_encode([
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }

    return;
}

if (($_SERVER['REQUEST_URI'] ?? '') === '/__dashboard-diagnostics') {
    header('Content-Type: application/json');

    try {
        $logPath = '/tmp/logs/laravel.log';

        if (file_exists($logPath)) {
            unlink($logPath);
        }

        define('LARAVEL_START', microtime(true));

        require __DIR__.'/../vendor/autoload.php';

        $app = require_once __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $user = App\Models\User::where('email', 'admin@ppproducoes.com')->first();

        if ($user) {
            Illuminate\Support\Facades\Auth::login($user);
        }

        $controller = $app->make(App\Http\Controllers\DashboardController::class);
        $view = $controller();

        echo json_encode([
            'user_found' => (bool) $user,
            'view' => $view->name(),
            'content_preview' => substr($view->render(), 0, 1000),
            'log_tail' => file_exists($logPath) ? substr(file_get_contents($logPath), -4000) : null,
        ]);
    } catch (Throwable $exception) {
        echo json_encode([
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'log_tail' => file_exists('/tmp/logs/laravel.log') ? substr(file_get_contents('/tmp/logs/laravel.log'), -4000) : null,
        ]);
    }

    return;
}

if (($_SERVER['REQUEST_URI'] ?? '') === '/__login-post-diagnostics') {
    header('Content-Type: application/json');

    try {
        $logPath = '/tmp/logs/laravel.log';

        if (file_exists($logPath)) {
            unlink($logPath);
        }

        define('LARAVEL_START', microtime(true));

        require __DIR__.'/../vendor/autoload.php';

        $app = require_once __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $request = Illuminate\Http\Request::create('/login', 'POST', [
            'email' => 'admin@ppproducoes.com',
            'password' => 'password',
        ]);

        $session = $app->make('session')->driver();
        $session->start();
        $request->setLaravelSession($session);

        $loginRequest = App\Http\Requests\Auth\LoginRequest::createFrom($request);
        $loginRequest->setContainer($app);
        $loginRequest->setRedirector($app->make('redirect'));
        $loginRequest->setLaravelSession($session);
        $loginRequest->authenticate();
        $loginRequest->session()->regenerate();

        echo json_encode([
            'authenticated' => Illuminate\Support\Facades\Auth::check(),
            'user_id' => Illuminate\Support\Facades\Auth::id(),
            'session_driver' => config('session.driver'),
            'session_secure' => config('session.secure'),
            'redirect_to' => route('dashboard', absolute: false),
            'log_tail' => file_exists($logPath) ? substr(file_get_contents($logPath), -4000) : null,
        ]);
    } catch (Throwable $exception) {
        echo json_encode([
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'log_tail' => file_exists('/tmp/logs/laravel.log') ? substr(file_get_contents('/tmp/logs/laravel.log'), -4000) : null,
        ]);
    }

    return;
}

try {
    require __DIR__.'/../public/index.php';
} catch (Throwable $exception) {
    error_log('VERCEL_EXCEPTION: '.$exception::class.' - '.$exception->getMessage());
    error_log($exception->getTraceAsString());

    if (getenv('APP_DEBUG') === 'true') {
        header('Content-Type: application/json', true, 500);

        echo json_encode([
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        return;
    }

    throw $exception;
}
