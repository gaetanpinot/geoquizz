<?php

namespace Geoquizz\Auth\core\services;

use Geoquizz\Auth\core\dto\AuthDTO;
use Geoquizz\Auth\core\dto\CredentialsDTO;

interface ServiceAuthInterface {
	public function createUser(CredentialsDTO $credentials, int $role): string;
	public function byCredentials(CredentialsDTO $credentials): AuthDTO;

}
