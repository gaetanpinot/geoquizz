<?php

namespace Geoquizz\Game\infrastructure\repository;

use Geoquizz\Game\infrastructure\entities\Serie;
use Geoquizz\Game\infrastructure\interfaces\SerieRepositoryInterface;
use DI\Container;
use GuzzleHttp\Client;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository implements SerieRepositoryInterface
{
    private Client $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function findAll(): array
    {
        $response = $this->guzzle->get('/items/serie');
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