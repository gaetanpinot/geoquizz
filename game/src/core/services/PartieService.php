<?php

namespace Geoquizz\Game\core\services;

use Geoquizz\Game\core\dto\InputPartieDTO;
use Geoquizz\Game\core\dto\PartieDTO;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\PartieInfraInterface;

class PartieService implements PartieServiceInterface
{
    protected PartieInfraInterface $partieRepository;

    public function __construct(PartieInfraInterface $partieRepository)
    {
        $this->partieRepository = $partieRepository;
    }

    public function getAllParties(): array
    {
        $parties = $this->partieRepository->getAllParties();
        $partiesDTO = [];
        foreach ($parties as $partie) {
            $partiesDTO[] = new PartieDTO($partie);
        }
        return $partiesDTO;
    }

    public function getPartieById(int $id): PartieDTO
    {
        $partie = $this->partieRepository->getPartieById($id);
        return new PartieDTO($partie);
    }

    public function createPartie(InputPartieDTO $partieDTO) : PartieDTO
    {
        $partie = new Partie();
        $partie->setIdSerie($partieDTO->id_serie);
        $partie->setIdJoueur($partieDTO->id_joueur);
        $partie->setStatus($partieDTO->status);
        $partie->setDifficulte($partieDTO->difficulte);
        $partie->setScore($partieDTO->score);

        $this->partieRepository->createPartie($partie);

        return new PartieDTO($partie);
    }
}
