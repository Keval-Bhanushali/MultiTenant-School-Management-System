<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Notice extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'notices';

    protected $fillable = [
        'tenant_id',
        'school_id',
        'noticeable_type',
        'noticeable_id',
        'title',
        'message',
        'target_role',
        'target_locale',
        'translated_messages',
        'scope',
        'publish_at',
        'created_by',
    ];

    protected $casts = [
        'translated_messages' => 'array',
    ];
}
