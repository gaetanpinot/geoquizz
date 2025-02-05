<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Geoquizz\Game\core\services\PartieService;
use Geoquizz\Game\infrastructure\entities\CoupJoue;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostCommencerPartieAction extends AbstractAction
{
    protected CoupJoueServiceInterface $coupJoueService;

    public function __construct(CoupJoueServiceInterface $coupJoueService)
    {
        $this->coupJoueService = $coupJoueService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        //decode jwt and comapre user id + get partie id from body

        //tmp val
        $uuidUser = "a0eebc99-9c0b-4ef8-bb6d-6bb9bd380a11";

        $data = $rq->getParsedBody();
        $idPartie = $data['id_partie'];

        $res = $this->coupJoueService->commencerPartie(new CommencerJeuDTO($idPartie, $uuidUser));
        return JsonRenderer::render($rs, 200, ['partie' => $res]);
    }
}