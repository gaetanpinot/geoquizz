<?php

namespace Geoquizz\Game\core\dto;

class CoupConfirmeResponseDTO extends DTO
{
    protected float $lat;
    protected float $lon;

    protected int $score;

    public function __construct(float $lat, float $lon, int $score)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->score = $score;
    }
    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLon(): float
    {
        return $this->lon;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}