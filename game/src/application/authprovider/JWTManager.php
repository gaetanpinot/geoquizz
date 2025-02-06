<?php

namespace Geoquizz\Game\application\authprovider;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use UnexpectedValueException;

class JWTManager
{
    protected string $key;
    protected string $algo;


    public function __construct(
        string $key,
        string $algo
    ) {
        $this->key = $key;
        $this->algo = $algo;

    }

    public function createPartieToken(int $id_partie): string
    {
        $payload = [
            'id_partie' => $id_partie,
        ] ;

        return JWT::encode($payload, $this->key, $this->algo);

    }

    public function decodeToken(string $token): array
    {
        try {
            return (array) JWT::decode($token, new Key($this->key, $this->algo));
        } catch(UnexpectedValueException $e) {
            throw new AuthInvalidException($e->getMessage());
        } catch(SignatureInvalidException $e) {
            throw new AuthInvalidException($e->getMessage());
        }
    }
}
