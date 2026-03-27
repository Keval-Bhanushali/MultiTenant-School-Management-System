<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Show AI attendance UI
    public function aiAttendance()
    {
        // ...logic stub
        return view('attendance.ai_attendance');
    }
}
