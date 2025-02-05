<?php

namespace Geoquizz\Game\core\services\interfaces;

use Geoquizz\Game\core\dto\InputPartieDTO;
use Geoquizz\Game\core\dto\PartieDTO;

interface PartieServiceInterface
{
    public function getPartieById(int $id): PartieDTO ;
    public function createPartie(InputPartieDTO $partieDTO) : PartieDTO;
    public function getAllParties(): array;
}
