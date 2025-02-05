<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\dto\InputPartieDTO;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
//        $data['id_joueur'] = JWT::decode(...

        //test data
//        $data = [
//            "id_serie" => 1,
//            "id_joueur" => "a0eebc99-9c0b-4ef8-bb6d-6bb9bd380a11",
//            "status" => 0,
//            "difficulte" => 1,
//            "score" => 0
//        ];

        $partieDto = new InputPartieDTO($data);

        $res = $this->partieService->createPartie($partieDto);

        return JsonRenderer::render($rs, 201, $res);
    }
}