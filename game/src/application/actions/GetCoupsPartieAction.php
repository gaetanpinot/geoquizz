<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Geoquizz\Game\core\services\PartieService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCoupsPartieAction extends AbstractAction
{
    protected PartieService $partieService;

    public function __construct(PartieService $partieService)
    {
        $this->partieService = $partieService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $idPartie = $args['id'];

        $coups = $this->partieService->getAllCoupsFromPartie($idPartie);
        return JsonRenderer::render($rs, 200, $coups);
    }
}