<?php

namespace Geoquizz\Game\application\authprovider;

use Geoquizz\Game\application\authprovider\PartieAuthProviderInterface;

class JWTAuthnProvider implements PartieAuthProviderInterface
{
    protected JWTManager $jwtManager;

    public function __construct(JWTManager $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }
    public function createPartie(int $id_partie): string
    {
        return $this->jwtManager->createPartieToken($id_partie);
    }

    public function getPartieById(string $token_partie): int
    {
        $decoded = $this->jwtManager->decodeToken($token_partie);
        return (int)$decoded['id_partie'];
    }

}
