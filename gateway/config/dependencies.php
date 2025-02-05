<?php

use Geoquizz\Gateway\application\middlewares\AuthnMiddleware;
use GuzzleHttp\Client;

use function DI\autowire;
use function DI\create;
use function DI\get;

return [
        Client::class => autowire(),
    AuthnMiddleware::class => create()->constructor(get(Client::class), get('auth.url')),
];
