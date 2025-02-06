<?php

namespace Geoquizz\Game\core\dto;

class CoupNextResponseDTO extends DTO
{
    protected int $idCoup;
    protected string $idImage;

    public function __construct(int $idCoup,string $idImage)
    {
        $this->idCoup = $idCoup;
        $this->idImage = $idImage;
    }

    public function getIdCoup(): int
    {
        return $this->idCoup;
    }

    public function getIdImage(): string
    {
        return $this->idImage;
    }
}