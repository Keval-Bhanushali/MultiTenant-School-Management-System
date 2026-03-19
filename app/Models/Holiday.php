<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Holiday extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'holidays';

    protected $fillable = [
        'school_id',
        'title',
        'date',
        'type',
        'description',
    ];
}
