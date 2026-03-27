<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GradingController extends Controller
{
    // Show AI grading & lesson generator UI
    public function aiGrading()
    {
        // ...logic stub
        return view('grading.ai_grading');
    }
}
