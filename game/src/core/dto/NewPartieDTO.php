<?php

namespace Geoquizz\Game\core\dto;

class NewPartieDTO extends DTO
{
    protected $id;
    protected $token;

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function __construct($id)
    {
        $this->id = $id;
    }

}

