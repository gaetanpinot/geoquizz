<?php

namespace Geoquizz\Game\core\dto;

class JouerCoupDTO extends DTO
{
    private int $idPartie;
    private float $lat;
    private float $lon;

    public function __construct(int $idPartie, float $lat, float $lon)
    {
        $this->idPartie = $idPartie;
        $this->lat = $lat;
        $this->lon = $lon;
    }

    public function getIdPartie(): int
    {
        return $this->idPartie;
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