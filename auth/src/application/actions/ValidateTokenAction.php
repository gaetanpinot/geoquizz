<?php

namespace Geoquizz\Auth\application\actions;

use DI\Container;
use Geoquizz\Auth\providers\auth\AuthnProviderInterface;
use PHPUnit\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;
use Geoquizz\Auth\providers\auth\AuthInvalidException;
use Geoquizz\Auth\application\renderer\JsonRenderer;

class ValidateTokenAction extends AbstractAction
{
    protected AuthnProviderInterface $authProvider;
    public function __construct(AuthnProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        if(!$rq->hasHeader("Authorization")) {

            throw new HttpUnauthorizedException($rq, "Header Authorization manquante, veuillez vous enregistrer");
        }
        try {
            $token = $rq->getHeader("Authorization")[0];
            $token = sscanf($token, "Bearer %s");
            if($token == null) {
                return JsonRenderer::render($rs, 400, ['error' => "Votre authentification n'est pas valide, veuillez vous reconnecter"]);
            }
            $token = $token[0];
            $user = $this->authProvider->getSignedInUser($token);
            $rq = $rq->withAttribute('user', $user);

            return JsonRenderer::render($rs, 200);



        } catch (AuthInvalidException $e) {
            /*$this->loger->error($e->getMessage());*/
            return JsonRenderer::render($rs, 401, ['error' => "Votre authentification n'est pas valide, veuillez vous reconnecter"]);
        } catch(\Error $e) {
            /*$this->loger->error($e->getMessage());*/
            return JsonRenderer::render($rs, 401, ['error' => "Erreur lors de l'authentification veuillez verifier votre token"]);
        }
    }
}
