<?php

namespace Geoquizz\Game\core\dto;

class CoupConfirmeResponseDTO extends DTO
{
    protected int $idCoup;
    protected float $lat;
    protected float $lon;

    protected int $score;

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