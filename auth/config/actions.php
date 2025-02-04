<?php

use Geoquizz\Game\application\actions\GetAllSeriesAction;

return [
GetAllSeriesAction::class => Di\autowire(),
    GetPartieAction::class => Di\autowire()
];
