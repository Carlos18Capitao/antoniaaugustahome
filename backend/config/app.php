<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;

return [

    'name' => env('APP_NAME', 'Antônio Augusta Home'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Europe/Lisbon',
    'locale' => 'pt',
    'fallback_locale' => 'en',
    'faker_locale' => 'pt_PT',
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'maintenance' => ['driver' => 'file'],

];
