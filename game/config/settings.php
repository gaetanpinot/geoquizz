<?php

return [

    //amqp config queue
    'exchange.name' => getenv('EXCHANGE'),
    'queue.name' => getenv('QUEUE'),
    'routing.key' => getenv('ROUTING_KEY'),

'auth.token.directus' => getenv('DIRECTUS_TOKEN'),

    //amqp config auth
    'amqp.host' => getenv('HOST'),
    'amqp.user' => getenv('USER'),
    'amqp.password' => getenv('PASSWORD'),
    'amqp.port' => getenv('PORT'),


    'jwt.key' => getenv('JWT_PARTIE_KEY'),
    'jwt.algo' => 'HS512',
];
