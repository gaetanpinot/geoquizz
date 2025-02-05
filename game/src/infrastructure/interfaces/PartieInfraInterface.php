<?php

namespace Geoquizz\Game\infrastructure\interfaces;

use Geoquizz\Game\infrastructure\entities\Partie;

interface PartieInfraInterface
{
    public function getPartieById(int $id): Partie;
    public function createPartie(Partie $partie): Partie;
    public function getAllParties(): array;

}
