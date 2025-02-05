<?php

namespace Geoquizz\Game\core\services;

use Geoquizz\Game\core\dto\SerieDTO;
use Geoquizz\Game\core\services\interfaces\SerieServiceInterface;
use Geoquizz\Game\infrastructure\repository\SerieRepository;

class SerieService implements SerieServiceInterface
{
    protected SerieRepository $serieRepository;

    public function __construct(SerieRepository $serieRepository)
    {
        $this->serieRepository = $serieRepository;
    }

    public function getSeries(): array
    {
    }

    public function getAllSeries(): array
    {
        $res = $this->serieRepository->findAll();
        $series = [];
        foreach ($res as $serie) {
            $series[] = new SerieDTO($serie);
        }
        return $series;

    }
}
