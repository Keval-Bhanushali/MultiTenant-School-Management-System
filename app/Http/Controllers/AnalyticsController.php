<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    // Show at-risk students analytics
    public function atRiskStudents()
    {
        // ...logic stub
        return view('analytics.at_risk_students');
    }
}
