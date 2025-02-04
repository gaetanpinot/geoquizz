<?php

namespace Geoquizz\Game\core\dto;

abstract class DTO implements \JsonSerializable
{
    public function jsonSerialize(): array
    {

        $retour =  get_object_vars($this);
        return $retour;
    }


    public function __get(string $name): mixed
    {
        return property_exists($this, $name) ? $this->$name : throw new \Exception(static::class . ": Property $name does not exist");
    }

    public function toJSON(): string
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

}
