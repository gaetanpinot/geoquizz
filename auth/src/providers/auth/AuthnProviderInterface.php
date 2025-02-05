<<<<<<< HEAD
<?php
namespace Geoquizz\Auth\providers\auth;

use Geoquizz\Auth\core\dto\AuthDTO;

use Geoquizz\Auth\core\dto\CredentialsDTO;

interface AuthnProviderInterface{
	public function register(CredentialsDTO $credentials):void;
	public function signin(CredentialsDTO $credentials):AuthDTO;
	public function refresh(AuthDTO $credentials):AuthDTO;
	public function getSignedInUser(string  $atoken):AuthDTO;
}
=======
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
>>>>>>> 6390e9ad73178e583c0528e4f1f770b12bf9ab1f
