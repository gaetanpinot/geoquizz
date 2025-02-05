<?php

namespace Geoquizz\Game\core\dto;

class CoupNextResponseDTO extends DTO
{
    private int $idCoup;
    private string $idPoint;

    public function __construct(int $idCoup,string $idPoint)
    {
        $this->idCoup = $idCoup;
        $this->idPoint = $idPoint;
    }

    public function getIdCoup(): int
    {
        return $this->idCoup;
    }

    public function getIdPhoto(): string
    {
        return $this->idPoint;
    }

}