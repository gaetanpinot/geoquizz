<?php

namespace Geoquizz\Game\core\dto;

class CoupNextResponseDTO extends DTO
{
    protected int $idCoup;
    protected string $idPoint;

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

    public function setIdCoup(int $idCoup): void
    {
        $this->idCoup = $idCoup;
    }

    public function setIdPhoto(string $idPoint): void
    {
        $this->idPoint = $idPoint;
    }

}