<?php

namespace Geoquizz\Auth\core\services;

use Geoquizz\Auth\core\domain\entities\User;
use Geoquizz\Auth\core\dto\AuthDTO;
use Geoquizz\Auth\core\dto\CredentialsDTO;
use Geoquizz\Auth\core\repositoryInterfaces\AuthRepositoryInterface;
use Geoquizz\Auth\infrastructure\repositories\RepositoryEntityAlreadyExistException;
use Geoquizz\Auth\infrastructure\repositories\RepositoryEntityNotFoundException;

class ServiceAuth implements ServiceAuthInterface
{
    protected AuthRepositoryInterface $repositoryAuth;
    public function __construct(AuthRepositoryInterface $repositoryAuth)
    {
        $this->repositoryAuth = $repositoryAuth;
    }

    public function createUser(CredentialsDTO $credentials)
    {
        $user = new User($credentials->id, $credentials->email, password_hash($credentials->password, PASSWORD_DEFAULT), $credentials->nom, $credentials->prenom);
        try {
            $this->repositoryAuth->createUser($user);
        } catch(RepositoryEntityAlreadyExistException $e) {
            throw new ServiceOperationInvalideException($e->getMessage());
        }
    }

    /*
    * Verifie les credentials avec ceux de la base de donnée
    */
    public function byCredentials(CredentialsDTO $credentials): AuthDTO
    {
        try {
            $user = $this->repositoryAuth->getUserByMail($credentials->email);
            if(!password_verify($credentials->password, $user->mot_de_passe)) {
                throw new ServiceAuthBadPasswordException("Mauvais mot de passe");
            }
            return new AuthDTO($user->id, $user->email);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceAuthUserNotFoundException("Utilisateur $credentials->id non trouvé");
        }
    }

}
