<?php

namespace Geoquizz\Game\infrastructure\repository;

use Geoquizz\Game\infrastructure\interfaces\PointRepositoryInterface;
use GuzzleHttp\Client;

class PointRepository implements PointRepositoryInterface
{
    private Client $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }
    public function getPoint($idPoint){
        $response = $this->guzzle->get('/items/point/'.$idPoint);
        $data = json_decode($response->getBody(), true);

        return $data['data'];
    }
}