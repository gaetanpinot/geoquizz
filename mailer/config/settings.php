<?php

use Geoquizz\Mailer\infra\amqp\Consumer;
use Geoquizz\Mailer\infra\mailer\MailerInterface;
use Geoquizz\Mailer\infra\mailer\MailerSymfony;
use Psr\Container\ContainerInterface;

use PhpAmqpLib\Connection\AMQPStreamConnection;

return [

    //amqp config
    'amqp.queue' => getenv('QUEUE'),
    'amqp.exchange' => getenv('EXCHANGE'),
    'amqp.routing_key' => getenv('ROUTING_KEY'),


    'amqp.host' => getenv('HOST'),
    'amqp.user' => getenv('USER'),
    'amqp.password' => getenv('PASSWORD'),
    'amqp.port' => getenv('PORT'),

    AMQPStreamConnection::class => function (ContainerInterface $c) {
        return new AMQPStreamConnection(
            $c->get('amqp.host'),
            $c->get('amqp.port'),
            $c->get('amqp.user'),
            $c->get('amqp.password')
        );
    },

    //dsn config

    'dsn' => getenv('DSN'),

    //dependences
    MailerInterface::class => DI\get(MailerSymfony::class),

    MailerSymfony::class => DI\create(MailerSymfony::class)
        ->constructor(DI\get('dsn')),

    //amqp consumer
    Consumer::class => DI\create(Consumer::class)
        ->constructor(DI\get(MailerInterface::class), DI\get(AMQPStreamConnection::class), DI\get('amqp.queue'), DI\get('amqp.exchange'), DI\get('amqp.routing_key')),
];
