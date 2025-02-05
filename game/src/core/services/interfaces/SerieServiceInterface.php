<?php

namespace Geoquizz\Game\core\services\interfaces;

interface SerieServiceInterface
{
    /**
     * @return array
     */
    public function getSeries(): array;
    public function getAllSeries(): array;
}
