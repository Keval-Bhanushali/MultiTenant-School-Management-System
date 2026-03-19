<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Notice extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'notices';

    protected $fillable = [
        'school_id',
        'title',
        'message',
        'target_role',
        'scope',
        'publish_at',
        'created_by',
    ];
}
