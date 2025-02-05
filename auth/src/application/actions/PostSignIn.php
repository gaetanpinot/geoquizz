<?php

namespace Geoquizz\Auth\application\actions;

use DI\Container;
use Error;
use Geoquizz\Auth\providers\auth\AuthnProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Geoquizz\Auth\application\renderer\JsonRenderer;
use Geoquizz\Auth\core\dto\CredentialsDTO;
use Geoquizz\Auth\core\services\ServiceAuthUserNotFoundException;

class PostSignIn extends AbstractAction
{
    protected AuthnProviderInterface $authProvider;
    public function __construct(AuthnProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $jsonSignIn = $rq->getParsedBody();

        $rdvInputValidator = Validator::key('email', Validator::email()->notEmpty())
            ->key('password', Validator::stringType()->notEmpty());

        try {
            //validation
            $rdvInputValidator->assert($jsonSignIn);
            //formatage

            $authDto = $this->authProvider->signin(new CredentialsDTO('', $jsonSignIn['password'], $jsonSignIn['email']));
            /*$rs = $rs->withHeader('access_token', $authDto->atoken);*/
            return JsonRenderer::render($rs, 201, ['data' => ['access_token' => $authDto->atoken]]);

            return $rs;
        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (ServiceAuthUserNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
            //            throw new HttpInternalServerErrorException($rq, "Erreur serveur");
        } catch (Error $e) {
            echo $e->getTraceAsString();
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }


    }
}
