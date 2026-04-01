<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AnalyticsInsight extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'analytics_insights';

    protected $fillable = [
        'school_id',
        'student_name',
        'risk_level',
        'attendance_rate',
        'test_score',
        'recommendation',
    ];
}
