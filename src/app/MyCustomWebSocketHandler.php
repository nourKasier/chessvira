<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class MyCustomWebSocketHandler implements MessageComponentInterface
{

    public function onOpen(ConnectionInterface $connection)
    {
        Log::info('WebSocket asdfg connection opened');
    }

    public function onClose(ConnectionInterface $connection)
    {
        Log::info('WebSocket asdfg connection close');
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        Log::info('WebSocket asdfg connection error');
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $msg)
    {
        Log::info('WebSocket  asdfg connection messaga');
    }
}
