<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'transactions';

    protected $fillable = [
        'tenant_id',
        'school_id',
        'wallet_id',
        'student_user_id',
        'type',
        'amount',
        'reference',
        'method',
        'channel',
        'status',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'float',
        'metadata' => 'array',
    ];
}
