<?php

namespace Geoquizz\Gateway\application\actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class ActionGetApiGenerique
{
    protected Client $client;
    public LoggerInterface $logger;
    protected string $url;


    /*
 * @param Client $client client guzzle generique
 * @param string $url url de l'api a contacter
 */

    public function __construct(Client $client, string $url)
    {
        $this->client = $client;
        $this->url = $url;
    }


    /*
 * Transfère la requete avec l'uri de la requete et sa méthode à l'api définie par le constructeur
  * @param array<int,mixed> $args
  */
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        // on recupère l'uri de la requete, il doit avoir un / en premier charactère
        $uri = $rq->getUri()->getPath();
        /*echo $rq->getMethod() . $uri;*/

        $headers = [];
        if ($rq->hasHeader("Authorization")) {
            $headers['Authorization'] = $rq->getHeader("Authorization")[0];
        }
        if ($rq->hasHeader("PartieAuthorization")) {
            $headers['PartieAuthorization'] = $rq->getHeader("PartieAuthorization")[0];
        }
        $headers['content-type'] = $rq->hasHeader('content-type') ? $rq->getHeader('content-type')[0] : 'application/json';
        $headers['accept'] = $rq->hasHeader('accept') ? $rq->getHeader('accept')[0] : 'application/json';

        try {
            $responseToubeelib = $this->client->request(
                $rq->getMethod(),
                $this->url. $uri,
                [
                   'timeout' => 25,
                   'headers' => $headers,
                   'json' => $rq->getParsedBody(),
                    'query' => $rq->getQueryParams(),

                ]
            );

            //slim met sur certaine requete(liste praticiens) ce header et ça casse tout
            return $responseToubeelib->withoutHeader('Transfer-Encoding');
        } catch (ConnectException | ServerException $e) {
            /*echo $e->getMessage();*/
            /*return $rs;*/
            return $e->getResponse();
        } catch (ClientException $e) {
            return $e->getResponse();

        }
    }


}
