<?php

namespace Geoquizz\Game\core\dto;

class NewPartieDTO extends DTO
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

}