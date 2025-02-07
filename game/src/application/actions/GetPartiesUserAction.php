<?php

namespace Geoquizz\Game\application\actions;

use Firebase\JWT\JWT;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPartiesUserAction extends AbstractAction
{
    protected PartieServiceInterface $partieService;

    public function __construct(PartieServiceInterface $partieService)
    {
        $this->partieService = $partieService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $user =  $rq->getAttribute('id_utilisateur');
        $parties = $this->partieService->getPartiesByUser($user);

        return JsonRenderer::render($rs, 200, $parties);

    }
}