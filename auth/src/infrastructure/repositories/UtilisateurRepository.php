<?php

namespace Geoquizz\Auth\infrastructure\repositories;

use Doctrine\ORM\EntityRepository;
use Geoquizz\Auth\core\domain\entities\User;
use Geoquizz\Auth\core\repositoryInterfaces\AuthRepositoryInterface;
use Geoquizz\Auth\infrastructure\entities\Utilisateur;

/**
 * @extends EntityRepository<object>
 */
class UtilisateurRepository extends EntityRepository implements AuthRepositoryInterface
{
    public function getUser(string $id): User
    {
        $dbUser = $this->find($id);
        if($dbUser == null) {
            throw new RepositoryEntityNotFoundException("Utilisateur $id non trouvé");
        }
        return $dbUser->toEntity();
    }

    public function getUserByMail(string $email): User
    {
        $dbUser =  $this->findOneBy(['email' => $email]);
        if($dbUser == null) {
            throw new RepositoryEntityNotFoundException("Utilisateur $email non trouvé");
        }
        return $dbUser->toEntity();

    }

    public function createUser(User $user): User
    {
    }

    public function deleteUser(string $id): void
    {
    }
}
