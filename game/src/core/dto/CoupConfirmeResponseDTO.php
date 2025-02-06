<?php

namespace Geoquizz\Game\core\dto;

class CoupConfirmeResponseDTO extends DTO
{
    protected int $nbCoupRestant;
    protected float $lat;
    protected float $lon;

    protected int $score;

    public function __construct(int $nbCoupRestant, float $lat, float $lon, int $score)
    {
        $this->nbCoupRestant = $nbCoupRestant;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->score = $score;
    }

    public function getNbCoup(): int
    {
        return $this->nbCoupRestant;
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