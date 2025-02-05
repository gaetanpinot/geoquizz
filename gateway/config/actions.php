<?php

use Geoquizz\Gateway\application\actions\ApiAuthAction;
use Geoquizz\Gateway\application\actions\ApiCMSAction;
use Geoquizz\Gateway\application\actions\ApiGameAction;
use GuzzleHttp\Client;

use function DI\create;
use function DI\get;

return [
        ApiAuthAction::class => create()->constructor(get(Client::class), get('auth.url')),
        ApiCMSAction::class => create()->constructor(get(Client::class), get('cms.url')),
        ApiGameAction::class => create()->constructor(get(Client::class), get('game.url')),
];
