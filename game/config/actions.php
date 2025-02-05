<?php

use Geoquizz\Game\application\actions\GetAllPartiesAction;
use Geoquizz\Game\application\actions\GetAllSeriesAction;
use Geoquizz\Game\application\actions\GetPartieAction;
use Geoquizz\Game\application\actions\PostPartieAction;

return [
    GetAllSeriesAction::class => Di\autowire(),
    GetPartieAction::class => Di\autowire(),
    GetAllPartiesAction::class => Di\autowire(),
    PostPartieAction::class => Di\autowire(),
];

