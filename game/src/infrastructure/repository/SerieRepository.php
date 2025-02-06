<?php

namespace Geoquizz\Game\infrastructure\repository;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use Geoquizz\Game\infrastructure\entities\Serie;
use Geoquizz\Game\infrastructure\interfaces\SerieRepositoryInterface;
use DI\Container;
use GuzzleHttp\Client;

class SerieRepository implements SerieRepositoryInterface
{
    private Client $guzzle;

    protected string $access_token;

    public function __construct(Client $guzzle, string $access_token)
    {
        $this->guzzle = $guzzle;
        $this->access_token = $access_token;

    }

    public function findById($id)
    {
        $response = $this->guzzle->get(
            '/items/serie/'.$id,
            [
                'headers' => [
                'Authorization' => "Bearer $this->access_token"]
            ]
        );
        $data = json_decode($response->getBody(), true);

        return new Serie(
            $data['data']['id'],
            $data['data']['nom'],
            $data['data']['difficulte'],
            $data['data']['point_serie']
        );
    }

    public function findAll(): array
    {
        $response = $this->guzzle->get(
            '/items/serie',
            [
                'headers' => [
                'Authorization' => "Bearer $this->access_token"]
            ]
        );
        $data = json_decode($response->getBody(), true);

        $series = [];
        foreach ($data['data'] as $serie) {
            $series[] = new Serie(
                $serie['id'],
                $serie['nom'],
                $serie['difficulte'],
                $serie['point_serie']
            );
        }
        return $series;
    }
}

