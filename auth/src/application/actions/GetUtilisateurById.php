<?php

namespace Geoquizz\Auth\application\actions;

use Geoquizz\Auth\application\renderer\JsonRenderer;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Geoquizz\Auth\core\services\ServiceAuthInterface;
use Geoquizz\Auth\application\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class GetUtilisateurById extends AbstractAction
{
    protected ServiceAuthInterface $serviceAuth;
    public function __construct(ServiceAuthInterface $serviceAuth)
    {
        $this->serviceAuth = $serviceAuth;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $validator = Validator::key('id', Validator::Uuid()->notEmpty());
        try {

            $validator->assert($args);
        } catch(NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
        $userDto = $this->serviceAuth->getUserById($args['id']);
        return JsonRenderer::render($rs, 200, ['user' => $userDto]);

    }

}
