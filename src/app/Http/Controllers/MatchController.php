<?php

namespace App\Http\Controllers;

use App\ChessMatch;
use App\Lobby;
use Domain\Matches\Actions\CheckGameStatusAction;
use Domain\Matches\Actions\CheckReadinessAction;
use Domain\Matches\Actions\GetDisconnectionTimeAction;
use Domain\Matches\Actions\GetPgnAction;
use Domain\Matches\Actions\GetPlayersTimesAction;
use Domain\Matches\Actions\JoinMatchAction;
use Domain\Matches\Actions\SetDisconnectionTimeAction;
use Domain\Matches\Actions\SetPlayersTimesAction;
use Domain\Matches\Actions\StartTheMatchAction;
use Domain\Matches\Actions\StoreMoveAction;
use Domain\Matches\Actions\UpdateReadinessAction;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function checkGameStatus()
    {
        $response = CheckGameStatusAction::run();

        return response()->json([
            'secondPlayerJoined' => $response['secondPlayerJoined'],
            'matchId' => $response['matchId'],
            'userColor' => $response['userColor'],
        ]);
    }

    public function start()
    {
        try {
            $response = StartTheMatchAction::run(auth()->user()->id);
            if ($response['redirectTo'] === 'match') {
                return redirect()->route('match.show', ['id' => $response['matchId']])
                    ->with('userColor', $response['color']);
            } else if ($response['redirectTo'] === 'lobby') {
                return redirect()->route('lobby.index')->with('message', 'Waiting for another player to join...');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.']);
        }
    }

    public function show($id)
    {
        // Find the match by ID
        $match = ChessMatch::findOrFail($id);
        $pgn = $match->pgn;
        // Pass the pgn and the match data to the view
        return view('matches.show', ['match' => $match, 'pgn' => $pgn]);
    }

    public function showLobbies()
    {
        $waitingLobbies = Lobby::where('status', 'waiting')->get();
        return view('lobby.index', ['waitingLobbies' => $waitingLobbies]);
    }

    public function join($id)
    {
        JoinMatchAction::run($id);
    }

    public function storeMove(Request $request)
    {
        try {
            $response = StoreMoveAction::run(
                $request->input('pgn'),
                $request->input('match_id'),
                $request->input('move'),
                $request->input('time_left'),
                $request->input('opponent_time_left'),
            );
            return response()->json(['success' => $response['success']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function menu()
    {
        return view('matches.menu');
    }

    public function getInitialPosition($matchId)
    {
        try {
            $response = GetPgnAction::run($matchId);
            return response()->json(['initialPosition' => $response['initialPosition']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getPgn($matchId)
    {
        try {
            $response = GetPgnAction::run($matchId);
            return response()->json(['pgn' => $response['pgn'], 'player1Time' => $response['player1Time'], 'player2Time' => $response['player2Time']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function setDisconnectionTime($matchId, $userColor)
    {
        try {
            $response = SetDisconnectionTimeAction::run($matchId, $userColor);
            return response()->json(['success' => $response['success']], $response['code']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getDisconnectionTime($matchId, $userColor)
    {
        try {
            $response = GetDisconnectionTimeAction::run($matchId, $userColor);

            return response()->json(['player1Time' => $response['player1Time'], 'player2Time' => $response['player2Time']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function setPlayersTimes(Request $request)
    {
        try {
            $response = SetPlayersTimesAction::run(
                $request->input('matchId'),
                $request->input('userColor'),
                $request->input('player1Time'),
                $request->input('player2Time')
            );
            return response()->json(['success' => $response['success']], $response['code']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getPlayersTimes(Request $request)
    {
        try {
            $response = GetPlayersTimesAction::run($request->input('matchId'));

            return response()->json(['player1Time' => $response['player1Time'], 'player2Time' => $response['player2Time']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function updateReadiness(Request $request)
    {
        try {
            $response = UpdateReadinessAction::run(
                $request->input('matchId'),
                $request->input('userColor'),
                $request->input('readiness')
            );

            return response()->json(['message' => $response['message']], $response['code']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function checkReadiness(Request $request)
    {
        try {
            $response = CheckReadinessAction::run($request->input('matchId'));

            return response()->json(['playersReady' => $response['playersReady']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
