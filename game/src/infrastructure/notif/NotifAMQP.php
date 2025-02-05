<?php

namespace Geoquizz\Game\infrastructure\notif;

use Geoquizz\Game\core\dto\PartieDTO;
use Geoquizz\Game\infrastructure\entities\Partie;
use Geoquizz\Game\infrastructure\interfaces\InfraNotifInterface;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class NotifAMQP implements InfraNotifInterface
{
    protected AMQPStreamConnection $connection;
    protected string $exchangeName;
    protected string $queueName;
    protected string $routingKey;
    public function __construct(AMQPStreamConnection $connection, string $exchangeName, string $queueName, string $routingKey)
    {
        $this->connection = $connection;
        $this->exchangeName = $exchangeName;
        $this->queueName = $queueName;
        $this->routingKey = $routingKey;
    }

    public function notifCreationPartie(Partie $partie): void
    {

        /*echo(getenv('EXCHANGE'));*/
        /*echo(" exchange: $this->exchangeName, queue: $this->queueName, routingKey: $this->routingKey\n");*/
        $channel = $this->connection->channel();
        $channel->exchange_declare($this->exchangeName, 'direct', false, true, false);
        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->queue_bind($this->queueName, $this->exchangeName, $this->routingKey);

        $body = <<<END
		<h1>Partie créée {$partie->getId()}</h1>
		<p>La partie {$partie->getId()} a été créée avec succès par {$partie->getIdJoueur()}
		sur la série {$partie->getStatus()}
		</p>
		END;
        $msg = new AMQPMessage($body);

        $channel->basic_publish($msg, $this->exchangeName, $this->routingKey);

        $channel->close();
    }
}
