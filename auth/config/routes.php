<?php

declare(strict_types=1);

use Geoquizz\Auth\application\actions\ValidateTokenAction;
use Geoquizz\Auth\application\actions\PostSignIn;
use Geoquizz\Auth\application\renderer\JsonRenderer;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

return function (\Slim\App $app): \Slim\App {


    $app->get("[/]", function ($request, $response) {

        return JsonRenderer::render($response, 200, ["message" => "Api geoquizz auth"]);
    });

    $app->post('/signin[/]', PostSignIn::class)->setName('signIn');

    $app->get('/validateToken[/]', ValidateTokenAction::class)->setName('ValidateToken');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
    return $app;

};
