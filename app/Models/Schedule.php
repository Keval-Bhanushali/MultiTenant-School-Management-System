<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Schedule extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'schedules';

    protected $fillable = [
        'school_id',
        'tenant_id',
        'name',
        'date',
        'status',
        'notes',
    ];
}
