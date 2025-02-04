<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\actions\AbstractAction;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPartieAction extends AbstractAction
{
    protected PartieServiceInterface $partieService;

    public function __construct(PartieServiceInterface $partieService)
    {
        $this->partieService = $partieService;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $partie = $this->partieService->getPartieById((int)$args["id"]);
        return JsonRenderer::render($rs, 200, ['partie' => $partie]);

    }

}
