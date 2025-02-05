<?php

use GuzzleHttp\Client;

use function DI\autowire;

return [
        Client::class => autowire(),
];
