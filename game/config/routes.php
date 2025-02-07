<?php

declare(strict_types=1);

use Geoquizz\Game\application\actions\ContinuerPartieAction;
use Geoquizz\Game\application\actions\GetAllPartiesAction;
use Geoquizz\Game\application\actions\GetAllSeriesAction;
use Geoquizz\Game\application\actions\GetCoupsPartieAction;
use Geoquizz\Game\application\actions\GetPartieAction;
use Geoquizz\Game\application\actions\GetPartiesUserAction;
use Geoquizz\Game\application\actions\GetProchainCoupAction;
use Geoquizz\Game\application\actions\PostConfirmePointAction;
use Geoquizz\Game\application\actions\PostPartieAction;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\middlewares\AuthJouerCoupPartie;
use Geoquizz\Game\middlewares\AuthzPartie;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

return function (\Slim\App $app): \Slim\App {


    $app->get("[/]", function ($request, $response) {

        return JsonRenderer::render($response, 200, ["message" => "Api game"]);
    });

    /*$app->group("/series", function (RouteCollectorProxy $group) {*/
    /*    $group->get("[/]", GetAllSeriesAction::class);*/
    /*});*/

    $app->group("/parties", function (RouteCollectorProxy $group) {
        $group->get("[/]", GetAllPartiesAction::class);

        $group->get("/{id}[/]", GetPartieAction::class);

        $group->get("/{id}/next", GetProchainCoupAction::class)->add(AuthJouerCoupPartie::class);

        $group->get("/{id}/coups", GetCoupsPartieAction::class);

        $group->post("[/]", PostPartieAction::class)->add(AuthzPartie::class);

        $group->post("/{id}/confirmer", PostConfirmePointAction::class)->add(AuthJouerCoupPartie::class);

        $group->get("/{id}/continuer[/]", ContinuerPartieAction::class)->add(AuthzPartie::class);
    });

    $app->get("/historique[/]", GetPartiesUserAction::class)->add(AuthzPartie::class);

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });

    return $app;
};
