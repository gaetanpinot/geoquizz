<?php

namespace Geoquizz\Game\infrastructure\entities;

class Serie
{

    protected $id;
    protected $nom;
    protected $difficulte;
    protected $point_serie;

    public function __construct($id, $nom, $difficulte, $point_serie)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->difficulte = $difficulte;
        $this->point_serie = $point_serie;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getDifficulte()
    {
        return $this->difficulte;
    }

    public function getPointSerie()
    {
        return $this->point_serie;
    }


}