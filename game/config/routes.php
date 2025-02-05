<?php

declare(strict_types=1);

use Geoquizz\Game\application\actions\GetAllPartiesAction;
use Geoquizz\Game\application\actions\GetAllSeriesAction;
use Geoquizz\Game\application\actions\GetCoupsPartieAction;
use Geoquizz\Game\application\actions\GetPartieAction;
use Geoquizz\Game\application\actions\PostCommencerPartieAction;
use Geoquizz\Game\application\actions\GetProchainCoupAction;
use Geoquizz\Game\application\actions\PostConfirmePointAction;
use Geoquizz\Game\application\actions\PostPartieAction;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

return function (\Slim\App $app): \Slim\App {


    $app->get("[/]", function ($request, $response) {

        return JsonRenderer::render($response, 200, ["message" => "Api game"]);
    });

    $app->group("/series", function (RouteCollectorProxy $group) {
        $group->get("[/]", GetAllSeriesAction::class);
    });

    $app->group("/parties", function (RouteCollectorProxy $group) {
        $group->get("[/]", GetAllPartiesAction::class);

        $group->get("/{id}[/]", GetPartieAction::class);

        $group->get("/{id}/next", GetProchainCoupAction::class);

        $group->get("/{id}/coups", GetCoupsPartieAction::class);

        $group->post("[/]", PostPartieAction::class);

//        $group->post("/{id}/commencer", PostCommencerPartieAction::class);

        $group->post("/{id}/confirmer", PostConfirmePointAction::class);
    });

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });

    return $app;

};
