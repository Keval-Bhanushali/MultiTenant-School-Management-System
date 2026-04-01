<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class School extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'schools';

    protected $fillable = [
        'tenant_id',
        'domain',
        'name',
        'code',
        'owner_name',
        'email',
        'phone',
        'settings',
        'subscription_plan',
        'status',
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
