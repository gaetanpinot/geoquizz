<<<<<<< HEAD
<?php
namespace Geoquizz\Auth\core\dto;

class CredentialsDTO extends DTO{

    public string $email,$id,$password;

    public function __construct(string $id, string $password, string $email)
    {
        $this->password=$password;
        $this->id=$id;
        $this->email = $email;
    }

}
=======
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
>>>>>>> 6390e9ad73178e583c0528e4f1f770b12bf9ab1f
