<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class RecurringTask extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'recurring_tasks';

    protected $fillable = [
        'school_id',
        'tenant_id',
        'task_name',
        'frequency',
        'meta',
        'is_active',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_active' => 'boolean',
    ];
}
