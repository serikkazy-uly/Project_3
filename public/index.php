<?php
if (!session_id()) @session_start();

use Delight\Auth\Auth;
use League\Plates\Engine;

require '../vendor/autoload.php';
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    Engine::class => function(){
        return new Engine('../app/views');
    },
    PDO::class=>function(){
        $driver = "mysql";
        $host = "mysql";
        $database_name = "laravel";
        $username = "user";
        $password = "secret";
        return new PDO("$driver:host=$host; dbname=$database_name", $username, $password);
    },
    // Delight\Auth\Auth - simplefield as Auth
    Auth::class=> function($container){
        return new Auth($container->get('PDO'));
    },
]);

$container = $containerBuilder->build();
// d($container);die;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/home', ['App\controllers\HomeController', 'index']);
    $r->addRoute('GET', '/user', ['App\controllers\HomeController', 'user']);
    $r->addRoute('GET', '/verification', ['App\controllers\HomeController', 'email_verification']);
    $r->addRoute('GET', '/login', ['App\controllers\HomeController', 'login']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
// d($routeInfo);die;
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND: //0
        echo '404 - Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED: // 2
        $allowedMethods = $routeInfo[1];
        echo  '405 - Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND: // 1
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

       $container->call($routeInfo[1], $routeInfo[2]);
        // d($cont);die;

        $controller = new $handler[0];
        call_user_func([$controller, $handler[1]], $vars);
        break;
}
