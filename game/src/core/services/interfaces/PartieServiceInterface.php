<?php

namespace Geoquizz\Game\core\services\interfaces;

use Geoquizz\Game\core\dto\PartieDTO;

interface PartieServiceInterface
{
    public function getPartieById(int $id): PartieDTO ;
}
