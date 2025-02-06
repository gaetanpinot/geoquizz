<?php

namespace Geoquizz\Game\core\authz;

interface AuthzPartieServiceInterface
{
    public function isGranted(string $idUser, int $idPartie): bool;
}
