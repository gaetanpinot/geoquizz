<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostConfirmePointAction extends AbstractAction
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
        $lat = $data['lat'];
        $lon = $data['lon'];

        $dto = new JouerCoupDTO($idPartie, $lat, $lon);
        $res = $this->coupJoueService->confirmePoint($dto);
        return JsonRenderer::render($rs, 200, ['coup' => $res]);

    }
}