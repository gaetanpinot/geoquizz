<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Geoquizz\Game\core\services\PartieService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAllPartiesAction extends AbstractAction
{
    protected PartieServiceInterface $partieService;
    public function __construct(PartieServiceInterface $partieService)
    {
        $this->partieService = $partieService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $parties = $this->partieService->getAllParties();
        return JsonRenderer::render($rs, 200, compact('parties'));
    }
}