<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Result extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'results';

    protected $fillable = [
        'school_id',
        'student_id',
        'standard_id',
        'subject_id',
        'exam_name',
        'marks',
        'grade',
        'published_at',
    ];
}
