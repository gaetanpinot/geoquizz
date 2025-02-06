<?php

namespace Geoquizz\Mailer\infra\amqp;

use Exception;
use Geoquizz\Mailer\infra\mailer\MailerInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    private MailerInterface $mailer;
    private AMQPStreamConnection $connection;
    private string $queue;
    private AMQPChannel $channel;

    public function __construct(MailerInterface $mailer, AMQPStreamConnection $connection, string $queue, string $exchangeName, string $routingKey)
    {
        $this->mailer = $mailer;
        $this->connection = $connection;
        $this->queue = $queue;
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare($exchangeName, 'direct', false, true, false);
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->queue_bind($this->queue, $exchangeName, $routingKey);

    }
    public function __invoke(AMQPMessage $msg): void
    {
        $this->mailer->send(
            'info@geoquizz',
            'client@geoquizz',
            'CREATION DE PARTIE',
            $msg->getBody(),
        );
        $msg->getChannel()->basic_ack($msg->getDeliveryTag());
    }


    public function handle(): void
    {
        $this->channel->basic_consume($this->queue, '', false, false, false, false, $this);
        try {
            $this->channel->consume();
        } catch (Exception $e) {
            print $e->getMessage();
        }
        $this->channel->close();
        $this->connection->close();
    }

}
