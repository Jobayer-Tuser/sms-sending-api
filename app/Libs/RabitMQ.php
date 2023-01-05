<?php

namespace App\Libs;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabitMQ
{
    private object $mqChannel;
    private object $connection;
    private string $queue;

    public function __construct(string $queue)
    {
        $this->queue = $queue;
        $this->connection = new AMQPStreamConnection(
            config("rabitmq.host"),
            config("rabitmq.port"),
            config("rabitmq.username"),
            config("rabitmq.password")
        );

        $this->mqChannel = $this->connection->channel();
        $this->mqChannel->queue_declare(
            $queue = $this->queue,
            $passive = false,
            $durable = true,
            $exclusive = false,
            $auto_delete = false,
            $noWait = false,
            $arguments = null,
            $ticket = null,
        );
    }

    public function publisher($data)
    {
        $message = new AMQPMessage(json_encode($data, JSON_UNESCAPED_SLASHES), ["delivery_mode" => 2]);
        $this->mqChannel->basic_publish($message, '', $this->queue);
            echo "Job Created for : ". $this->queue;
    }

    public function consumer()
    {
        $callback = function ($msg){
            $data = json_decode($msg->body, true);
            // data to handle

            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $this->mqChannel->basic_qos(null, 1, null);
        $this->mqChannel->basic_consume($this->queue, '', false, false, false, false, $callback);

        while (count($this->mqChannel->callbacks)) {
            $callback->wait();
        }
        $this->mqChannel->close();
        $this->connection->close();
    }
}