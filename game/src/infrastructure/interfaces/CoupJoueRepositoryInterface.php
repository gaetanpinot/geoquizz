<?php

namespace Geoquizz\Game\infrastructure\interfaces;

use Geoquizz\Game\core\dto\CommencerJeuDTO;
use Geoquizz\Game\core\dto\CoupConfirmeResponseDTO;
use Geoquizz\Game\core\dto\CoupNextResponseDTO;
use Geoquizz\Game\core\dto\JouerCoupDTO;

interface CoupJoueRepositoryInterface
{
    public function coupsInit(int $idPartie, array $idsPoints): void;
    public function joueCoup(JouerCoupDTO $jouerCoupDTO);
    public function modifCoupDateJoue(int $idPartie):void;
    public function calculerNbCoupsRestant(int $idPartie) : int;
}