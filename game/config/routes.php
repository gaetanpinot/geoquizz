<?php

declare(strict_types=1);

use Geoquizz\Game\application\actions\GetAllSeriesAction;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

return function (\Slim\App $app): \Slim\App {


    $app->get("[/]", function ($request, $response) {

        return JsonRenderer::render($response, 200, ["message" => "Api game"]);
    });

    $app->group("/serie", function (RouteCollectorProxy $group) {
        $group->get("[/]", GetAllSeriesAction::class);
    });


    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });

    return $app;

};
