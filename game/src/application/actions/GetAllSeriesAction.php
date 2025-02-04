<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\actions\AbstractAction;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAllSeriesAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        return JsonRenderer::render($rs, 201, ["message" => "Hello World"]);
    }
}
