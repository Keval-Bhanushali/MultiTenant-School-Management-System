<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Subject extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'subjects';

    protected $fillable = [
        'school_id',
        'standard_id',
        'name',
        'code',
    ];
}
