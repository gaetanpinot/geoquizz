<?php

namespace Geoquizz\Auth\providers\auth;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Geoquizz\Auth\core\dto\AuthDTO;

class JWTManager
{
    protected int $tempsValidite;
    protected string $emmeteur;
    protected string $audience;
    protected string $key;
    protected string $algo;


    public function __construct(
        int $tempsValidite,
        string $emmeteur,
        string $audience,
        string $key,
        string $algo
    ) {
        $this->tempsValidite = $tempsValidite;
        $this->emmeteur = $emmeteur;
        $this->audience = $audience;
        $this->key = $key;
        $this->algo = $algo;

    }

    public function createAcessToken(AuthDTO $user): string
    {
        /*
        * Données nécessaires pour créer le token:
        * temps de validité à partir de maintenant
        * emmetteur du token
        * audience du token
        * sujet du token (id de l'user)
        */
        $payload = [
            'iss' => $this->emmeteur,
            'aud' => $this->audience,
            'iat' => time(),
            'exp' => time() + $this->tempsValidite,
            'sub' => $user->id,
            'email' => $user->email,
            /*'role' => $user->role,*/
        ] ;

        return JWT::encode($payload, $this->key, $this->algo);


    }
    /**
     * @param array<int,mixed> $paylod
     */
    public function createRefresh(array $paylod): string
    {
    }

    public function decodeToken(string $token): array
    {
        try {
            return (array) JWT::decode($token, new Key($this->key, $this->algo));
        } catch(ExpiredException $e) {
            /*$this->loger->error($e->getMessage());*/
            throw new AuthInvalidException($e->getMessage());
        }
    }
}
