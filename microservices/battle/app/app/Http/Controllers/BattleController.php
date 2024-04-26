<?php

namespace App\Http\Controllers;

use App\Algorithm\Dice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BattleController extends Controller
{
    public function __construct(private Dice $dice)
    {
    }

    public function duel(Request $request): JsonResponse
    {
        $battleAlgorithm = new Dice();
        $duelResult = $battleAlgorithm->fight();
        return response()->json(
            [
                'player1' => $request->input('userA'),
                'player2' => $request->input('userB'),
                'duelResults' => $duelResult
            ]
        );
    }
}
