<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetProchainCoupAction extends AbstractAction
{

    protected CoupJoueServiceInterface $coupJoueService;

    public function __construct(CoupJoueServiceInterface $coupJoueService)
    {
        $this->coupJoueService = $coupJoueService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        //decode jwt get user uuid

        //get id from url
        $idPartie = $args['id'];
        $data = $rq->getParsedBody();

        $res = $this->coupJoueService->nextCoup($idPartie);
        return JsonRenderer::render($rs, 200, ['coup' => $res]);
    }
}