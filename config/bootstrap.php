<?php
declare(strict_types=1);

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Log\Log;

require dirname(__DIR__) . '/vendor/autoload.php';

if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
define('ROOT', dirname(__DIR__));
define('APP_DIR', 'src');
define('WEBROOT_DIR', 'webroot');
define('WWW_ROOT', ROOT . DS . WEBROOT_DIR . DS);
define('CONFIG', ROOT . DS . 'config' . DS);
define('TMP', ROOT . DS . 'tmp' . DS);
define('LOGS', ROOT . DS . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('APP', ROOT . DS . 'src' . DS);
define('CORE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);

if (file_exists(ROOT . DS . '.env')) {
    Dotenv\Dotenv::createImmutable(ROOT)->safeLoad();
}
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed {
        $value = $_SERVER[$key] ?? $_ENV[$key] ?? getenv($key);
        return $value === false || $value === null ? $default : $value;
    }
}
Configure::config('default', new \Cake\Core\Configure\Engine\PhpConfig());
Configure::load('app', 'default', false);
if (file_exists(CONFIG . 'app_local.php')) { Configure::load('app_local', 'default'); }
date_default_timezone_set(Configure::read('App.defaultTimezone', 'UTC'));
if (Configure::read('debug')) { error_reporting(E_ALL); ini_set('display_errors', '1'); }
Log::setConfig(Configure::consume('Log'));
Cache::setConfig(Configure::consume('Cache'));
