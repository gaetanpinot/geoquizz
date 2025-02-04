<?php

namespace Geoquizz\Game\infrastructure\interfaces;

use Geoquizz\Game\infrastructure\entities\Partie;

interface PartieInfraInterface
{
    public function getPartieById(int $id): Partie;
}
