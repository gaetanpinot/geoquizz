<?php

namespace Geoquizz\Game\application\actions;

use Geoquizz\Game\application\actions\AbstractAction;
use Geoquizz\Game\application\authprovider\PartieAuthProviderInterface;
use Geoquizz\Game\application\renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContinuerPartieAction extends AbstractAction
{
    protected PartieAuthProviderInterface $partieAuthProvider;

    public function __construct(PartieAuthProviderInterface $partieAuthProvider)
    {
        $this->partieAuthProvider = $partieAuthProvider;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id_partie = $args['id'];
        $token = $this->partieAuthProvider->createPartie($id_partie);

        return JsonRenderer::render($rs, 201, ['token' => $token]);
    }
}
