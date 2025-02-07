<?php

namespace Geoquizz\Game\core\dto;

class InputPartieDTO extends DTO
{
    protected int $id_serie;
    protected ?string $id_joueur;
    protected int $status;
    protected int $difficulte;
    protected int $score;

    public function __construct(array $data)
    {
        $this->id_serie = $data['id_serie'];
        $this->id_joueur = $data['id_joueur'];
        $this->status = 1;
        $this->difficulte = $data['difficulte'];
        $this->score = 0;
    }

    public function __get(string $name): mixed
    {
        return property_exists($this, $name) ? $this->$name : throw new \Exception(static::class . ": Property $name does not exist");
    }
}

