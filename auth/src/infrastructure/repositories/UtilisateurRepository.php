<?php

namespace Geoquizz\Auth\infrastructure\repositories;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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

    public function createUser(User $user)
    {
        $dbUser = new Utilisateur();
        $dbUser->setEmail($user->email);
        $dbUser->setMotDePasse($user->mot_de_passe);
        $dbUser->setNom($user->nom);
        $dbUser->setPrenom($user->prenom);
        try {
            $this->getEntityManager()->persist($dbUser);
            $this->get->flush();
        } catch(UniqueConstraintViolationException $e) {
            throw new RepositoryEntityAlreadyExistException("Utilisateur $user->email déjà existant");
        }
    }

    public function deleteUser(string $id): void
    {
    }

    public function getUsers(array $ids): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.id in (:ids)')
        ->setParameter('ids', $ids, ArrayParameterType::STRING);

        $users = $qb->getQuery()->getResult();
        if($users === null || count($users) == 0) {
            return [];
        }
        return array_map(function ($user) {
            return $user->toEntity();
        }, $users);
    }
}
