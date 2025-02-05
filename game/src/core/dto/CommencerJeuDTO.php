<?php

namespace Geoquizz\Game\core\dto;

class CommencerJeuDTO extends DTO
{
    private int $idPartie;
    private string $idJoueur;

    public function __construct($idPartie, $idJoueur)
    {
        $this->idPartie = $idPartie;
        $this->idJoueur = $idJoueur;
    }

    public function getIdPartie(): int
    {
        return $this->idPartie;
    }

    public function getIdJoueur(): string
    {
        return $this->idJoueur;
    }
}