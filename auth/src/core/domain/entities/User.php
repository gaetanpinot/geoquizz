<?php

namespace Geoquizz\Auth\core\domain\entities;

class User extends Entity
{
    protected string $email;
    protected string $mot_de_passe;
    protected string $nom;
    protected string $prenom;


    public function __construct(string $id, string $email, string $password, string $nom, string $prenom)
    {
        $this->id = $id;
        $this->email = $email;
        $this->mot_de_passe = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }


}
