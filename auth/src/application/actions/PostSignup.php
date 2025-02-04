<?php

namespace Geoquizz\Auth\application\actions;

use Geoquizz\Auth\core\dto\CredentialsDTO;
use Geoquizz\Auth\core\services\ServiceOperationInvalideException;
use Geoquizz\Auth\providers\auth\AuthnProviderInterface;
use Geoquizz\Auth\application\renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

class PostSignup extends AbstractAction
{
    protected AuthnProviderInterface $authProvider;
    public function __construct(AuthnProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $dataSignUp = $rq->getParsedBody();

        $rdvInputValidator = Validator::key('email', Validator::email()->notEmpty())
            ->key('password', Validator::stringType()->notEmpty())
            ->key('nom', Validator::stringType()->notEmpty())
            ->key('prenom', Validator::stringType()->notEmpty());
        try {
            $rdvInputValidator->assert($dataSignUp);

            $credentials = new CredentialsDTO('', $dataSignUp['password'], $dataSignUp['email'], $dataSignUp['nom'], $dataSignUp['prenom']);
            $auth = $this->authProvider->register($credentials);
            return JsonRenderer::render($rs, 201, [])->withHeader('Authorization', $auth->atoken);
        } catch(NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch(ServiceOperationInvalideException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

    }
}
