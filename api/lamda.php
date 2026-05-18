<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// 🔥 បង្ខំផ្លូវ Storage និងផ្លូវ Cache ទាំងអស់ឱ្យទៅរត់លើ /tmp ទាំងអស់គ្នា
$app->useStoragePath('/tmp/storage');

// បង្កើត Folder ណាដែលខ្វះខាតនៅក្នុង /tmp ភ្លាមៗពេលកូដដំណើរការ
$targetFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache'
];

foreach ($targetFolders as $folder) {
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
    }
}

// បង្ខំផ្លូវសម្រាប់ហ្វាយ Cache របស់ Bootstrap ឱ្យមកនៅថត /tmp ដែរ
$app->bootstrapPath(); 
// ----------------------------------------------------

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);