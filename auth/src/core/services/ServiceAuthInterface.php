<<<<<<< HEAD
<?php

namespace Geoquizz\Auth\core\services;

use Geoquizz\Auth\core\dto\AuthDTO;
use Geoquizz\Auth\core\dto\CredentialsDTO;

interface ServiceAuthInterface {
	public function createUser(CredentialsDTO $credentials, int $role): string;
	public function byCredentials(CredentialsDTO $credentials): AuthDTO;

}
=======
<?php

namespace Geoquizz\Auth\core\services;

use Geoquizz\Auth\core\dto\AuthDTO;
use Geoquizz\Auth\core\dto\CredentialsDTO;
use Geoquizz\Auth\core\dto\UtilisateurDTO;

interface ServiceAuthInterface
{
    public function createUser(CredentialsDTO $credentials) ;
    public function byCredentials(CredentialsDTO $credentials): AuthDTO;
    public function getUserById(string $id): UtilisateurDTO;
    public function getUsersById(array $ids): array;

}
>>>>>>> 6390e9ad73178e583c0528e4f1f770b12bf9ab1f
