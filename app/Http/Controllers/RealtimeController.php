<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RealtimeController extends Controller
{
    // Show GPS & WebRTC UI
    public function gpsWebrtc()
    {
        // ...logic stub
        return view('realtime.gps_webrtc');
    }
}
