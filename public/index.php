<?php
if (!session_id()) {
    session_start();
}

require '../vendor/autoload.php';
// use function Tamtamchik\SimpleFlash\flash;
// d($_SERVER);die;
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/users', ['App\controllers\HomeController', 'index']);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}', ['App\controllers\HomeController', 'index']);

    $r->addRoute('GET', '/users/{id:\d+}/company/classes/school/{number:\d+}', ['App\controllers\HomeController', 'about']);

    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
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
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND: //0
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED: // 2
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break; 
    case FastRoute\Dispatcher::FOUND: // 1
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // вызов контроллера
        $controller = new $handler[0];
        // $controller->index(789); 
        // d($controller);
        // exit;

        call_user_func([$controller, $handler[1]], $vars);
        // ... call $handler with $vars
        break;
}
