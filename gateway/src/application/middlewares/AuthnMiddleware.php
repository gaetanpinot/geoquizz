<?php

namespace Geoquizz\Gateway\application\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpInternalServerErrorException;

class AuthnMiddleware implements MiddlewareInterface
{
    protected LoggerInterface $loger;

    protected string $url;

    protected Client $client;


    public function __construct(Client $c, string $url)
    {
        $this->client = $c;
        $this->url = $url;
    }

    public function process(ServerRequestInterface $rq, RequestHandlerInterface $next): ResponseInterface
    {

        try {
            $uri = '/validateToken';
            $responseToubeelib = $this->client->request(
                'GET',
                $this->url. $uri,
                [
                    'timeout' => 5,
                    'headers' => $rq->getHeaders(),
                    'json' => $rq->getParsedBody(),

                ]
            );
        } catch (ConnectException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());

        } catch(ServerException $e) {
            return $e->getResponse();
            /*throw new HttpInternalServerErrorException($rq, $e->getMessage());*/
        } catch (ClientException $e) {
            return $e->getResponse();
        }



        $rs = $next->handle($rq);
        //après requete
        return $rs;
    }

}
