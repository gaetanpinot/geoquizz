<?php

use Geoquizz\Game\application\actions\GetAllPartiesAction;
use Geoquizz\Game\application\actions\GetAllSeriesAction;
use Geoquizz\Game\application\actions\GetCoupsPartieAction;
use Geoquizz\Game\application\actions\GetPartieAction;
use Geoquizz\Game\application\actions\GetProchainCoupAction;
use Geoquizz\Game\application\actions\PostCommencerPartieAction;
use Geoquizz\Game\application\actions\PostConfirmePointAction;
use Geoquizz\Game\application\actions\PostPartieAction;

return [
    GetAllSeriesAction::class => Di\autowire(),
    GetPartieAction::class => Di\autowire(),
    GetAllPartiesAction::class => Di\autowire(),
    PostPartieAction::class => Di\autowire(),
    PostCommencerPartieAction::class => Di\autowire(),
    PostConfirmePointAction::class => Di\autowire(),
    GetProchainCoupAction::class => Di\autowire(),
    GetCoupsPartieAction::class => Di\autowire()
];

