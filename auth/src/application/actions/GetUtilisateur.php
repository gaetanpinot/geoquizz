<?php

namespace Geoquizz\Auth\application\actions;

use Geoquizz\Auth\application\actions\AbstractAction;
use Geoquizz\Auth\application\renderer\JsonRenderer;
use Geoquizz\Auth\core\services\ServiceAuthInterface;
use Geoquizz\Auth\providers\auth\AuthInvalidException;
use Geoquizz\Auth\providers\auth\AuthnProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpUnauthorizedException;

class GetUtilisateur extends AbstractAction
{
    protected AuthnProviderInterface $authProvider;
    protected ServiceAuthInterface $serviceAuth;
    public function __construct(AuthnProviderInterface $authProvider, ServiceAuthInterface $service)
    {
        $this->authProvider = $authProvider;
        $this->serviceAuth = $service;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        if(!$rq->hasHeader("Authorization")) {

            throw new HttpUnauthorizedException($rq, "Header Authorization manquante, veuillez vous enregistrer");
        }
        try {
            $token = $rq->getHeader("Authorization")[0];
            $token = sscanf($token, "Bearer %s");
            if($token === null) {
                return JsonRenderer::render($rs, 400, ['error' => "Votre authentification n'est pas valide, veuillez vous reconnecter"]);
            }
            $token = $token[0];
            $id_user = $this->authProvider->getSignedInUser($token)->id;

            $user = $this->serviceAuth->getUserById($id_user);

            return JsonRenderer::render($rs, 200, ['utilisateur' => $user]);

        } catch (AuthInvalidException $e) {
            return JsonRenderer::render($rs, 401, ['error' => "Votre authentification n'est pas valide, veuillez vous reconnecter"]);
        } catch(\Error $e) {
            return JsonRenderer::render($rs, 401, ['error' => "Erreur lors de l'authentification veuillez verifier votre token"]);
        }
    }
}
