<?php

namespace Geoquizz\Game\middlewares;

use Geoquizz\Game\application\authprovider\AuthInvalidException;
use Geoquizz\Game\application\authprovider\PartieAuthProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Routing\RouteContext;

class AuthJouerCoupPartie implements MiddlewareInterface
{
    private PartieAuthProviderInterface $partieAuth;

    public function __construct(PartieAuthProviderInterface $partieRepository)
    {
        $this->partieAuth = $partieRepository;
    }

    public function process(ServerRequestInterface $rq, RequestHandlerInterface $handler): ResponseInterface
    {
        if(!$rq->hasHeader('PartieAuthorization')) {
            throw new HttpUnauthorizedException($rq, "Token PartieAuthorization manquant");
        }
        $token = $rq->getHeader('PartieAuthorization')[0];

        try {
            $id_partie_token = $this->partieAuth->getPartieById($token);
        } catch(AuthInvalidException $e) {
            throw new HttpUnauthorizedException($rq, "Token invalide");
        }

        $routeContext = RouteContext::fromRequest($rq);
        $route = $routeContext->getRoute();
        $id_partie_rq = $route->getArgument('id');

        if($id_partie_token != $id_partie_rq) {
            throw new HttpUnauthorizedException($rq, "Vous n'avez pas accès à cette partie");
        }
        $response = $handler->handle($rq);
        return $response;
    }
}
