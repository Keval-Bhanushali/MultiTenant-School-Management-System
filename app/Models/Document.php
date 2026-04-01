<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Document extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'documents';

    protected $fillable = [
        'tenant_id',
        'school_id',
        'user_id',
        'type',
        'file_path',
        'status',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];
}
