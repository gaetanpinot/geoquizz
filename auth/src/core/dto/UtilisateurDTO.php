<?php

namespace Geoquizz\Auth\core\dto;

use Geoquizz\Auth\core\domain\entities\User;
use Geoquizz\Auth\core\dto\DTO;

class UtilisateurDTO extends DTO
{
    protected string $id;
    protected string $email;
    protected string $nom;
    protected string $prenom;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->email = $user->email;
        $this->nom = $user->nom;
        $this->prenom = $user->prenom;
    }
}
