<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Attendance extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'attendances';

    protected $fillable = [
        'school_id',
        'entity_type',
        'entity_id',
        'date',
        'status',
        'remark',
    ];
}
