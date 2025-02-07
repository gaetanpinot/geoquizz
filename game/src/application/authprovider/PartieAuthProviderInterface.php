<?php

namespace Geoquizz\Game\application\authprovider;

interface PartieAuthProviderInterface
{
    public function createPartie(int $id_partie): string;
    public function getPartieById(string $token_partie): int;
}
