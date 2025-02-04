<?php
namespace Geoquizz\Auth\core\repositoryInterfaces;

use Geoquizz\Auth\core\domain\entities\User;

interface AuthRepositoryInterface {
    public function getUser(string $id): User;
    public function getUserByMail(string $email): User;
    public function createUser(User $user): User;
    public function deletUser(string $id): void;
}
