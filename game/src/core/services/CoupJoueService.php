<?php

namespace Geoquizz\Game\core\services;

use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\dto\CoupConfirmeResponseDTO;
use Geoquizz\Game\core\dto\CoupNextResponseDTO;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Geoquizz\Game\infrastructure\interfaces\CoupJoueRepositoryInterface;
use Geoquizz\Game\infrastructure\interfaces\PointRepositoryInterface;
use Geoquizz\Game\infrastructure\repository\CoupJoueRepository;

class CoupJoueService implements CoupJoueServiceInterface
{
    protected CoupJoueRepositoryInterface $coupsJoueRepository;
    protected PointRepositoryInterface $pointRepository;

    public function __construct(CoupJoueRepositoryInterface $coupsJoueRepository, PointRepositoryInterface $pointRepository)
    {
        $this->coupsJoueRepository = $coupsJoueRepository;
        $this->pointRepository = $pointRepository;
    }

//    public function commencerPartie(CommencerJeuDTO $commencerJeuDTO): CoupNextResponseDTO{
//
//        $res = $this->coupsJoueRepository->commencerPartie($commencerJeuDTO);
//        return $res;
//    }

    public function joueCoup(JouerCoupDTO $jouerCoupDTO): CoupConfirmeResponseDTO{
        $coupJoue = $this->coupsJoueRepository->joueCoup($jouerCoupDTO);

        $point = $this->pointRepository->getPoint($coupJoue->getIdPoint());
        return new CoupConfirmeResponseDTO($coupJoue->getId(), $point['lat'], $point['long'], 0);
    }

    public function nextCoup(int $idPartie): CoupNextResponseDTO{
        $res = $this->coupsJoueRepository->prochainCoup($idPartie);

        $idImage = $this->pointRepository->getPoint($res->getIdPoint())['image'];

        return new CoupNextResponseDTO($res->getId(), $idImage);
    }
}