<?php

namespace Geoquizz\Game\core\services;

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

    public function getPartieById(int $id): PartieDTO
    {
        $partie = $this->partieRepository->getPartieById($id);
        return new PartieDTO($partie);
    }
}
