<?php
declare(strict_types=1);

use Cake\Cache\Engine\FileEngine;
use Cake\Log\Engine\FileLog;

return [
    'debug' => filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    'App' => [
        'namespace' => 'App', 'encoding' => 'UTF-8', 'defaultLocale' => 'en_US',
        'defaultTimezone' => 'Asia/Manila', 'base' => false, 'dir' => 'src',
        'webroot' => 'webroot', 'wwwRoot' => WWW_ROOT,
        'fullBaseUrl' => env('APP_URL', 'http://localhost:8765'),
        'imageBaseUrl' => 'img/', 'cssBaseUrl' => 'css/', 'jsBaseUrl' => 'js/',
        'paths' => ['plugins' => [ROOT . DS . 'plugins' . DS], 'templates' => [ROOT . DS . 'templates' . DS]],
    ],
    'Security' => ['salt' => env('SECURITY_SALT', 'please-change-this-to-a-long-random-value')],
    'Error' => [
        'errorLevel' => E_ALL,
        'exceptionRenderer' => \Cake\Error\Renderer\WebExceptionRenderer::class,
        'skipLog' => [], 'log' => true,
    ],
    'Asset' => ['cacheTime' => '+1 year'],
    'Cache' => [
        'default' => ['className' => FileEngine::class, 'path' => CACHE, 'url' => env('CACHE_DEFAULT_URL', null)],
        '_cake_core_' => ['className' => FileEngine::class, 'prefix' => 'sis_cake_core_', 'path' => CACHE . 'persistent' . DS, 'serialize' => true, 'duration' => '+1 years'],
        '_cake_model_' => ['className' => FileEngine::class, 'prefix' => 'sis_cake_model_', 'path' => CACHE . 'models' . DS, 'serialize' => true, 'duration' => '+1 years'],
    ],
    'Log' => [
        'error' => ['className' => FileLog::class, 'path' => LOGS, 'file' => 'error', 'levels' => ['warning','error','critical','alert','emergency']],
        'debug' => ['className' => FileLog::class, 'path' => LOGS, 'file' => 'debug', 'levels' => ['notice','info','debug']],
    ],
];
