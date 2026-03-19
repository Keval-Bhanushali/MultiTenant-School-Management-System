<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class TimetableEntry extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'timetable_entries';

    protected $fillable = [
        'school_id',
        'standard_id',
        'subject_id',
        'teacher_id',
        'day',
        'start_time',
        'end_time',
        'is_holiday',
        'holiday_type',
    ];
}
