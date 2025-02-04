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
