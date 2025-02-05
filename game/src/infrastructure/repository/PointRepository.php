<?php

namespace Geoquizz\Game\infrastructure\repository;

use Geoquizz\Game\infrastructure\interfaces\PointRepositoryInterface;
use GuzzleHttp\Client;

class PointRepository implements PointRepositoryInterface
{
    private Client $guzzle;

    private string $access_token;

    public function __construct(Client $guzzle, string $access_token)
    {
        $this->guzzle = $guzzle;
        $this->access_token = $access_token;
    }

    public function getIdImage($idPoint)
    {
        $response = $this->guzzle->get(
            '/items/point/'.$idPoint,
            [
            'headers' => [
            'Authorization' => "Bearer $this->access_token",
                ]
            ]
        );
        $data = json_decode($response->getBody(), true);

        return $data['data']['image'];
    }


}

