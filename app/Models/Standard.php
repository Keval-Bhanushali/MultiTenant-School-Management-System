<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Standard extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'standards';

    protected $fillable = [
        'school_id',
        'name',
        'order',
        'status',
    ];
}
