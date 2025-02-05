<?php

namespace Geoquizz\Game\core\dto;

class SerieDTO extends DTO
{

    protected int $id;
    protected string $nom;
    protected int $difficulte;
    protected array $point_serie;


    public function __construct($serie)
    {
        $this->id = $serie->getId();
        $this->nom = $serie->getNom();
        $this->difficulte = $serie->getDifficulte();
        $this->point_serie = $serie->getPointSerie();
    }
}