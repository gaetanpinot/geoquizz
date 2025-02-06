<?php

namespace Geoquizz\Game\core\authz;

use Geoquizz\Game\core\authz\AuthzPartieServiceInterface;
use Geoquizz\Game\core\services\ServiceEntityNotFoundException;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Geoquizz\Game\infrastructure\interfaces\InfraEntityNotFoundException;
use Geoquizz\Game\infrastructure\interfaces\PartieInfraInterface;
use Geoquizz\Game\infrastructure\repository\PartieRepository;

class AuthzPartieService implements AuthzPartieServiceInterface
{
    protected PartieInfraInterface $partieRepo;
    public function __construct(PartieInfraInterface $partieRepo)
    {
        $this->partieRepo = $partieRepo;
    }
    public function isGranted(string $idUser, int $idPartie): bool
    {
        try {
            $partie = $this->partieRepo->getPartieById($idPartie);
            if($partie->getIdJoueur() == $idUser) {
                return true;
            } else {
                return false;
            }
        } catch(InfraEntityNotFoundException $e) {
            throw new ServiceEntityNotFoundException("Partie $idPartie n'existe pas");
        }
    }
}
