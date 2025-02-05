<?php

namespace Geoquizz\Game\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

class CorsMiddleware implements MiddlewareInterface{

    public function process(ServerRequestInterface $rq, RequestHandlerInterface $handler ): ResponseInterface {
        $response = $handler->handle($rq);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'OPTIONS, POST, GET, PUT, PATCH, DELETE')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, X-Requested-With');
    }
}