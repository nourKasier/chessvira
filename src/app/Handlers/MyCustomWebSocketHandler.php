<?php

namespace App\Handlers;

use App\ChessMatch;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class MyCustomWebSocketHandler implements MessageComponentInterface
{

    public function onOpen(ConnectionInterface $connection)
    {
        dd('hiiiiiiiiiiiiiddopen');
        // Create a match record
        $match = new ChessMatch();
        $match->white_player_id = 1;
        $match->black_player_id = 20;
        $match->initial_time = now();
        $match->player1_time = 500;
        $match->player2_time = 500;
        $match->player1_last_move_timestamp = now();
        $match->player2_last_move_timestamp = now();
        $match->save();
    }

    public function onClose(ConnectionInterface $connection)
    {
        dd('hiiiiiiiiiiiiiddopencloi');
        $match = new ChessMatch();
        $match->white_player_id = 1;
        $match->black_player_id = 50;
        $match->initial_time = now();
        $match->player1_time = 500;
        $match->player2_time = 500;
        $match->player1_last_move_timestamp = now();
        $match->player2_last_move_timestamp = now();
        $match->save();
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        dd('hiiiiiiiiiiiiiddopeeenerr');
        $match = new ChessMatch();
        $match->white_player_id = 1;
        $match->black_player_id = 23;
        $match->initial_time = now();
        $match->player1_time = 500;
        $match->player2_time = 500;
        $match->player1_last_move_timestamp = now();
        $match->player2_last_move_timestamp = now();
        $match->save();
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $msg)
    {
        dd('hiiiiiiiiiiiiiddopenmes');
        $match = new ChessMatch();
        $match->white_player_id = 1;
        $match->black_player_id = 22;
        $match->initial_time = now();
        $match->player1_time = 500;
        $match->player2_time = 500;
        $match->player1_last_move_timestamp = now();
        $match->player2_last_move_timestamp = now();
        $match->save();
    }
}
