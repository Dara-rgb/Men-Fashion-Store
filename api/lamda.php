<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

// ----------------------------------------------------
// កូដចាស់របស់បង៖ $app = require_once __DIR__.'/../bootstrap/app.php';
// ----------------------------------------------------
$app = require_once __DIR__.'/../bootstrap/app.php';

// 🔥 បន្ថែមកូដបង្ខំផ្លូវថ្មីត្រង់ចំណុចនេះ (ដើម្បីដោះស្រាយរឿង Read-only)
$app->useStoragePath('/tmp/storage');
if (!file_exists('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}
// ----------------------------------------------------

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);