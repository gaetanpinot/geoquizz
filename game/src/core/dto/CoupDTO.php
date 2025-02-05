<?php

namespace Geoquizz\Game\core\dto;

use Doctrine\DBAL\Types\Types;
use Geoquizz\Game\infrastructure\entities\CoupJoue;
use Geoquizz\Game\infrastructure\entities\Partie;

class CoupDTO extends DTO
{
    public ?int $id;
    public ?Partie $partie;
    public ?int $idPoint;
    public ?\DateTimeInterface $dateJoue;
    public ?float $lat;
    public ?float $long;

    public function __construct(CoupJoue $coupJoue)
    {
        $this->id = $coupJoue->getId();
        $this->partie = $coupJoue->getPartie();
        $this->idPoint = $coupJoue->getIdPoint();
        $this->dateJoue = $coupJoue->getDateJoue();
        $this->lat = $coupJoue->getLat();
        $this->long = $coupJoue->getLong();
    }

}