<?php

namespace Geoquizz\Auth\core\dto;

use Geoquizz\Auth\core\domain\entities\User;

class AuthDTO extends DTO
{
    protected string $id;
    protected string $email;
    protected string $atoken;
    protected string $refreshToken;

    public function __construct(string $id, string $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function setAtoken(string $tok): void
    {
        $this->atoken = $tok;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public static function fromUser(User $user)
    {
        $this->id = $user->id;
    }

}
