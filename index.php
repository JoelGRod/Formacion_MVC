<?php

// Composer - Autoloader
require_once __DIR__ . '/vendor/autoload.php';

// use namespaces
use Formacion\Core\Router;
use Formacion\Core\Request;
// Namespaces for DependencyInjector
use Formacion\Utils\DependencyInjector;
use Formacion\Core\Config;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
// Models
use Formacion\Models\BecarioModel;

// Start Dependency Injector definition
$config = new Config();
// Db
$dbConfig = $config->get('db');
$db = new PDO('mysql:host=127.0.0.1;dbname=formacion', $dbConfig['user'], $dbConfig['password']);
// Template Engine
$loader = new FilesystemLoader('views/');
$view = new Environment($loader);
// Logger
$log = new Logger('formacion');
$logFile = $config->get('log');
$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
// DI
$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Utils\Config', $config);
$di->set('Twig_Environment', $view);
$di->set('Logger', $log);
$di->set('BecarioModel', new BecarioModel($di->get('PDO')));  
// End Dependency Injector definition

$router = new Router($di);
$response = $router->route(new Request());
echo $response;
    
?>