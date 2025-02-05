<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\actions\AbstractAction;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\services\interfaces\SerieServiceInterface;
use Geoquizz\Game\core\services\SerieService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAllSeriesAction extends AbstractAction
{

    protected SerieServiceInterface $serieService;

    public function __construct(SerieServiceInterface $serieService)
    {
        $this->serieService = $serieService;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $series = $this->serieService->getAllSeries();
        return JsonRenderer::render($rs, 200, compact('series'));
    }
}
