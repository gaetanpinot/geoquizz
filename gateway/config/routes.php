<?php

declare(strict_types=1);
use Geoquizz\Gateway\application\actions\ApiAuthAction;
use Geoquizz\Gateway\application\actions\ApiCMSAction;
use Geoquizz\Gateway\application\actions\ApiGameAction;
use Geoquizz\Gateway\application\middlewares\AuthnMiddleware;
use Slim\Exception\HttpNotFoundException;
use Geoquizz\Gateway\application\renderer\JsonRenderer;
use Slim\Routing\RouteCollectorProxy;

return function (\Slim\App $app): \Slim\App {


    $app->get("[/]", function ($request, $response) {
        return JsonRenderer::render($response, 200, ["message" => "Api geoquizz gateway"]);
    });

    $app->post('/login[/]', ApiAuthAction::class);
    $app->post('/signup[/]', ApiAuthAction::class);

    $app->get('/utilisateur[/]', ApiAuthAction::class)->add(AuthnMiddleware::class);

    /*$app->get('/series[/]', ApiGameAction::class);*/

    $app->group('/parties', function (RouteCollectorProxy $group) {
        $group->get('/{id}', ApiGameAction::class);
        $group->get('/{id}/continuer[/]', ApiGameAction::class)->add(AuthnMiddleware::class);
        $group->map(['GET','POST','PUT','DELETE','PATCH'], '{routes:.*}', ApiGameAction::class);
    });


    $app->group('/items', function (RouteCollectorProxy $group) {
        $group->map(['GET','POST','PUT','DELETE','PATCH'], '{routes:.+}', ApiCMSAction::class);
    });

    $app->get('/assets/{id}', ApiCMSAction::class);

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
    return $app;

};
