<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\core\services\exceptions\ServiceEntityNotFoundException;
use Geoquizz\Game\core\services\exceptions\ServicePartieTermineException;
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
        $lon = $data['long'];
        //        $idCoup = $data['id_coup'];

        $dto = new JouerCoupDTO($idPartie, $lat, $lon);
        try {
            $res = $this->coupJoueService->joueCoup($dto);
        } catch(ServicePartieTermineException $e) {
            return JsonRenderer::render($rs, 400, ['error' => 'Partie terminée']);
        } catch(ServiceEntityNotFoundException $e) {
            return JsonRenderer::render($rs, 404, ['error' => $e->getMessage()]);
        }
        return JsonRenderer::render($rs, 200, $res);

    }
}

