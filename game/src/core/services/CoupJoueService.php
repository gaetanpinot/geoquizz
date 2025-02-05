<?php

namespace Geoquizz\Game\core\services;

use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\dto\CoupResponseDTO;
use Geoquizz\Game\core\services\interfaces\CoupJoueServiceInterface;
use Geoquizz\Game\infrastructure\repository\CoupJoueRepository;

class CoupJoueService implements CoupJoueServiceInterface
{
    protected CoupJoueRepository $coupsJoueRepository;

    public function __construct(CoupJoueRepository $coupsJoueRepository)
    {
        $this->coupsJoueRepository = $coupsJoueRepository;
    }

    public function commencerPartie(CommencerJeuDTO $commencerJeuDTO): CoupResponseDTO{
        $res = $this->coupsJoueRepository->commencerPartie($commencerJeuDTO);
        return new CoupResponseDTO($res);
    }
}