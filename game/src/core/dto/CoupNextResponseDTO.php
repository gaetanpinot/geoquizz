<?php

namespace Geoquizz\Game\core\dto;

use Respect\Validation\Rules\DateTime;

class CoupNextResponseDTO extends DTO
{
    protected int $nbCoupsRestants;
    protected string $idImage;
    protected int $secondesRestantes;

    protected int $difficulte;
    protected int $serieId;
    protected int $nbCoupsTotal;

    public function __construct(int $nbCoupsRestants, string $idImage, int $secondesRestantes, int $nbCoupsTotal, int $difficulte, int $serieId)
    {
        $this->nbCoupsRestants = $nbCoupsRestants;
        $this->idImage = $idImage;
        $this->secondesRestantes = $secondesRestantes;
        $this->nbCoupsTotal = $nbCoupsTotal;
        $this->difficulte = $difficulte;
        $this->serieId = $serieId;
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