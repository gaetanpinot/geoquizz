<?php

declare(strict_types=1);
use Geoquizz\Gateway\application\actions\ApiAuthAction;
use Geoquizz\Gateway\application\actions\ApiCMSAction;
use Geoquizz\Gateway\application\actions\ApiGameAction;
use Slim\Exception\HttpNotFoundException;
use Geoquizz\Gateway\application\renderer\JsonRenderer;
use Slim\Routing\RouteCollectorProxy;

return function (\Slim\App $app): \Slim\App {


    $app->get("[/]", function ($request, $response) {

        return JsonRenderer::render($response, 200, ["message" => "Api geoquizz gateway"]);
    });

    $app->post('/login[/]', ApiAuthAction::class);
    $app->post('/signup[/]', ApiAuthAction::class);

    $app->group('/partie', function (RouteCollectorProxy $group) {
        $group->map(['GET','POST','PUT','DELETE','PATCH'], '{routes:.+}', ApiGameAction::class);
    });

    $app->group('/items', function (RouteCollectorProxy $group) {
        $group->map(['GET','POST','PUT','DELETE','PATCH'], '{routes:.+}', ApiCMSAction::class);
    });

    $app->get('/assets/{id}', ApiCMSAction::class);


    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
    return $app;

};
