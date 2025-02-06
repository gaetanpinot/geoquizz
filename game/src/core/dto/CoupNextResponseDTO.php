<?php

namespace Geoquizz\Game\core\dto;

use Respect\Validation\Rules\DateTime;

class CoupNextResponseDTO extends DTO
{
    protected int $nbCoupsRestants;
    protected string $idImage;

    protected int $secondesRestantes;
    public function __construct(int $nbCoupsRestants,string $idImage, $secondesRestantes)
    {
        $this->nbCoupsRestants = $nbCoupsRestants;
        $this->idImage = $idImage;
        $this->secondesRestantes = $secondesRestantes;
    }

    public function getSecondesRestantes(): int
    {
        return $this->secondesRestantes;
    }

    public function getNbCoupRestants(): int
    {
        return $this->nbCoupsRestants;
    }

    public function getIdImage(): string
    {
        return $this->idImage;
    }
}