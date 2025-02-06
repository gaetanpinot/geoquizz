<?php

namespace Geoquizz\Game\infrastructure\interfaces;

use Geoquizz\Game\infrastructure\entities\Partie;

interface InfraNotifInterface
{
    public function notifCreationPartie(Partie $partie): void;
}
