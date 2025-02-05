<?php

namespace Geoquizz\Auth\application\actions;

use Geoquizz\Auth\application\actions\AbstractAction;
use Geoquizz\Auth\application\renderer\JsonRenderer;
use Geoquizz\Auth\core\services\ServiceAuthInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;

class GetUtilisateur extends AbstractAction
{
    protected ServiceAuthInterface $serviceAuth;
    public function __construct(ServiceAuthInterface $serviceAuth)
    {
        $this->serviceAuth = $serviceAuth;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getQueryParams();
        $validator = Validator::Uuid();
        try {
            if(!isset($data['ids'])) {
                throw new HttpBadRequestException($rq, "ids manquant");
            }
            $ids = json_decode($data['ids']);
            foreach($ids as $value) {
                $validator->assert($value);
            }
        } catch(NestedValidationException $e) {
            throw new HttpBadRequestException($rq, "Ids invalides");
        }

        $users = $this->serviceAuth->getUsersById($ids);
        $retour = [];
        foreach($users as $user) {
            $retour[$user->id] = $user;
        }
        return JsonRenderer::render($rs, 200, ['utilisateurs' => $retour]);
    }
}
