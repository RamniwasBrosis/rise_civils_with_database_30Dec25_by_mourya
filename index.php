<?php
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Update the path to the autoload file
require __DIR__.'/vendor/autoload.php';

// Update the path to the app's bootstrap file
$app = require_once __DIR__.'/bootstrap/app.php';
