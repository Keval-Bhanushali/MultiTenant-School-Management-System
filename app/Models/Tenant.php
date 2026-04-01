<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Tenant extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'tenants';

    protected $fillable = [
        'domain',
        'name',
        'settings',
        'subscription_plan',
        'status',
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
