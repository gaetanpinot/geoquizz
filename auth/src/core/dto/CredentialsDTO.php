<?php

namespace Geoquizz\Auth\core\dto;

class CredentialsDTO extends DTO
{
    public string $email;
    public string $id;
    public string $password;
    public ?string $nom;
    public ?string $prenom;

    public function __construct(string $id, string $password, string $email, string $nom = null, string $prenom = null)
    {
        $this->password = $password;
        $this->id = $id;
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

}
