<?php

namespace Geoquizz\Game\middlewares;

use Geoquizz\Game\core\authz\AuthzPartieServiceInterface;
use Geoquizz\Game\core\services\ServiceEntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Routing\RouteContext;
use Firebase\JWT\JWT;

class AuthzPartie implements MiddlewareInterface
{
    protected AuthzPartieServiceInterface $authPartieService;
    public function __construct(AuthzPartieServiceInterface $authPartieService)
    {
        $this->authPartieService = $authPartieService;
    }

    public function process(ServerRequestInterface $rq, RequestHandlerInterface $next): ResponseInterface
    {
        //Lignes pour récupérer le token et le décoder -->
        $idPartie = RouteContext::fromRequest($rq)->getRoute()->getArgument('id');

        $token = $rq->getHeader("Authorization")[0];
        $token = sscanf($token, "Bearer %s")[0];

        //methode pour decoder sans la clé
        [, $payload_b64] = explode('.', $token);
        $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($payload_b64));

        try {
            if($this->authPartieService->isGranted($payload->sub, $idPartie)) {
                return $next->handle($rq);
            } else {
                throw new HttpUnauthorizedException($rq, "Accès à la partie $idPartie non authorisé");
            }
        } catch(ServiceEntityNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }


        $rs = $next->handle($rq);
        //après requete
        return $rs;
    }

}
