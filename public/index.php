<?php

use App\Models\Weather;
use App\Response;
use App\Router\Router;
use App\WeatherApi;
use Carbon\Carbon;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/../app/Views');
$twig = new Environment($loader);
$weather = (new WeatherApi())->fetchData('london');
$twig->addExtension(new DebugExtension());
$twig->addGlobal('currentTime', Carbon::now());
$twig->addGlobal('currentWeather', new Weather($weather->getTemperature(), $weather->getWindSpeed()));
$currentDate = new DateTime();
$routeInfo = Router::dispatch();
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        [$className, $method] = $routeInfo[1];
        $vars = $routeInfo[2];

        $response = (new $className())->{$method}($vars);

        /** @var Response $response */
        echo $twig->render($response->getViewName() . '.twig', $response->getData());
        break;
}