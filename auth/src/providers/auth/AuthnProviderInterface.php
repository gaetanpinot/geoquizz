<?php

namespace Geoquizz\Auth\providers\auth;

use Geoquizz\Auth\core\dto\AuthDTO;

use Geoquizz\Auth\core\dto\CredentialsDTO;

interface AuthnProviderInterface
{
    public function register(CredentialsDTO $credentials): AuthDTO;
    public function signin(CredentialsDTO $credentials): AuthDTO;
    public function refresh(AuthDTO $credentials): AuthDTO;
    public function getSignedInUser(string  $atoken): AuthDTO;
}
