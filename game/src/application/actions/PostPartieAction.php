<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\dto\InputPartieDTO;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;

class PostPartieAction extends AbstractAction
{
    protected PartieServiceInterface $partieService;

    public function __construct(PartieServiceInterface $partieService)
    {
        $this->partieService = $partieService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $validation = Validator::key("id_serie", Validator::intType()->notEmpty())
        ->key("difficulte", Validator::intType()->notEmpty());

        try {
            $validation->assert($data);
        } catch(NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
        $data['id_joueur'] = $rq->getAttribute('id_utilisateur');

        $partieDto = new InputPartieDTO($data);

        $res = $this->partieService->createPartie($partieDto);

        return JsonRenderer::render($rs, 201, $res);
    }
}

