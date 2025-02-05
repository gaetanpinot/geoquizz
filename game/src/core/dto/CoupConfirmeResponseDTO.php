<?php

namespace Geoquizz\Game\core\dto;

class CoupConfirmeResponseDTO extends DTO
{
    private int $idCoup;
    private float $lat;
    private float $lon;

    private int $score;

    public function __construct(int $idCoup, float $lat, float $lon, int $score)
    {
        $this->idCoup = $idCoup;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->score = $score;
    }

    public function getIdCoup(): int
    {
        return $this->idCoup;
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