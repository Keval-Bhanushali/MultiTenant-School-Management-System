<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class LiveSession extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'live_sessions';

    protected $fillable = [
        'school_id',
        'title',
        'teacher_name',
        'meeting_link',
        'starts_at',
        'status',
    ];
}
