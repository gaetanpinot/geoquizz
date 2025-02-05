<?php

namespace Geoquizz\Game\core\dto;

class JouerCoupDTO extends DTO
{
    private int $idCoup;
    private float $lat;
    private float $lon;

    public function __construct(int $idCoup, float $lat, float $lon)
    {
        $this->idCoup = $idCoup;
        $this->lat = $lat;
        $this->lon = $lon;
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

}