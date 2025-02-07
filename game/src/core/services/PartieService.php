<?php

namespace Geoquizz\Game\core\services;

use Geoquizz\Game\core\dto\CoupDTO;
use Geoquizz\Game\core\dto\InputPartieDTO;
use Geoquizz\Game\core\dto\NewPartieDTO;
use Geoquizz\Game\core\dto\PartieDTO;
use Geoquizz\Game\core\services\interfaces\PartieServiceInterface;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\CoupJoueRepositoryInterface;
use Geoquizz\Game\infrastructure\interfaces\InfraNotifInterface;
use Geoquizz\Game\infrastructure\interfaces\PartieInfraInterface;
use Geoquizz\Game\infrastructure\interfaces\SerieRepositoryInterface;

class PartieService implements PartieServiceInterface
{
    private const NB_MANCHES = 10;
    protected PartieInfraInterface $partieRepository;
    protected CoupJoueRepositoryInterface $coupJoueRepository;
    protected InfraNotifInterface $notif;
    protected SerieRepositoryInterface $serieRepository;

    public function __construct(
        CoupJoueRepositoryInterface $coupJoueRepository,
        PartieInfraInterface $partieRepository,
        SerieRepositoryInterface $serieRepository,
        InfraNotifInterface $notif
    ) {
        $this->partieRepository = $partieRepository;
        $this->coupJoueRepository = $coupJoueRepository;
        $this->serieRepository = $serieRepository;
        $this->notif = $notif;
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

    public function getPartiesByUser($idUser): array
    {
        $parties = $this->partieRepository->getPartiesByUser($idUser);
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

    public function getAllCoupsFromPartie($idPartie): array
    {
        $coups = $this->coupJoueRepository->getAllCoupsFromPartie($idPartie);

        $coupsDTO = [];
        foreach ($coups as $coup) {
            $coupsDTO[] = new CoupDTO($coup);
        }
        return $coupsDTO;
    }

    public function createPartie(InputPartieDTO $partieDTO): NewPartieDTO
    {
        $partie = new Partie();
        $partie->setIdSerie($partieDTO->id_serie);
        $partie->setIdJoueur($partieDTO->id_joueur);
        $partie->setStatus($partieDTO->status);
        $partie->setDifficulte($partieDTO->difficulte);
        $partie->setScore($partieDTO->score);
        $partie->setNbCoupsTotal(floor(self::NB_MANCHES / $partieDTO->difficulte));

        $this->partieRepository->createPartie($partie);

        $serie = $this->serieRepository->findById($partieDTO->id_serie);
        $this->coupJoueRepository->coupsInit($partie->getId(), $serie->getPointSerie(), $partie->getNbCoupsTotal());
        $this->notif->notifCreationPartie($partie);

        return new NewPartieDTO($partie->getId());
    }
}

