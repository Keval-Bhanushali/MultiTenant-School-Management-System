<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    // Show calendar & recurring engine UI
    public function index()
    {
        // ...logic stub
        return view('calendar.index');
    }
}
