<?php

namespace Geoquizz\Auth\core\repositoryInterfaces;

use Geoquizz\Auth\core\domain\entities\User;

interface AuthRepositoryInterface
{
    public function getUser(string $id): User;
    public function getUserByMail(string $email): User;
    public function createUser(User $user) ;
    public function deleteUser(string $id): void;
    public function getUsers(array $ids): array;
}
