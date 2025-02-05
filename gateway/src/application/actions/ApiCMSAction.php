<?php

namespace Geoquizz\Gateway\application\actions;

use Geoquizz\Gateway\application\actions\ActionGetApiGenerique;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiCMSAction extends ActionGetApiGenerique
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

    }
}
