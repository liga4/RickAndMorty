<?php

require_once "vendor/autoload.php";

use App\Controllers\ArticleController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('App/Views');
$twig = new Environment($loader, [
]);

$controller = new ArticleController();
$controller->index($twig);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/articles', ['App\Controllers\ArticleController', 'index']);
    $router->addRoute('GET', '/articles-show/{articleIndex}', ['App\Controllers\ArticleController', 'show']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $vars = $routeInfo[2];

        [$controller, $method] = $routeInfo[1];
        $response = (new $controller)->{$method}($twig, $vars['articleIndex']);
        echo $response;
        break;
}