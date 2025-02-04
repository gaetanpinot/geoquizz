<?php

namespace Geoquizz\Game\core\dto;

use Geoquizz\Game\infrastructure\entities\Partie;

class PartieDTO extends DTO
{
    protected int $id;
    protected int $id_serie;
    protected string $id_joueur;
    protected int $status;
    protected int $difficulte;
    protected int $score;

    public function __construct(Partie $partie)
    {
        $this->id = $partie->getId();
        $this->id_serie = $partie->getIdSerie();
        $this->id_joueur = $partie->getIdJoueur();
        $this->status = $partie->getStatus();
        $this->difficulte = $partie->getDifficulte();
        $this->score = $partie->getScore();
    }
}
