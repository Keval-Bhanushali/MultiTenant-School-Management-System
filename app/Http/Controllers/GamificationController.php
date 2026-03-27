<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GamificationController extends Controller
{
    // Show house points leaderboard
    public function leaderboard()
    {
        // ...logic stub
        return view('gamification.leaderboard');
    }
}
