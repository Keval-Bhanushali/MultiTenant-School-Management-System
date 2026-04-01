<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Wallet extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'wallets';

    protected $fillable = [
        'tenant_id',
        'school_id',
        'user_id',
        'parent_user_id',
        'balance',
        'currency',
        'status',
    ];

    protected $casts = [
        'balance' => 'float',
    ];
}
