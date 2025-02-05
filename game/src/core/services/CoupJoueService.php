<?php

namespace Geoquizz\Game\core\services;

use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\dto\CoupConfirmeResponseDTO;
use Geoquizz\Game\core\dto\CoupNextResponseDTO;
use Geoquizz\Game\core\dto\JouerCoupDTO;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Geoquizz\Game\infrastructure\repository\CoupJoueRepository;

class CoupJoueService implements CoupJoueServiceInterface
{
    protected CoupJoueRepository $coupsJoueRepository;

    public function __construct(CoupJoueRepository $coupsJoueRepository)
    {
        $this->coupsJoueRepository = $coupsJoueRepository;
    }

    public function commencerPartie(CommencerJeuDTO $commencerJeuDTO): CoupNextResponseDTO{

        $res = $this->coupsJoueRepository->commencerPartie($commencerJeuDTO);
        return $res;
    }

    public function joueCoup(JouerCoupDTO $jouerCoupDTO): CoupConfirmeResponseDTO{

        $res = $this->coupsJoueRepository->joueCoup($jouerCoupDTO);
        return $res;
    }

    public function nextCoup(int $idPartie): CoupNextResponseDTO{
        $res = $this->coupsJoueRepository->prochainCoup($idPartie);
        return $res;
    }
}