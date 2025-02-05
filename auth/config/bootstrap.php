<?php

use DI\ContainerBuilder;
use Geoquizz\Auth\CorsMiddleware;
use Slim\Factory\AppFactory;

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php');
$builder->addDefinitions(__DIR__ . '/dependencies.php');
$builder->addDefinitions(__DIR__ . '/actions.php');

$c = $builder->build();

$app = AppFactory::createFromContainer($c);

$app->addBodyParsingMiddleware();
$app->addMiddleware($c->get(CorsMiddleware::class));
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);


$app = (require_once __DIR__ . '/routes.php')($app);


return $app;
