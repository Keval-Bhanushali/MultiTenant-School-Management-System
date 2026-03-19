<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Announcement extends Model
{
    protected $collection = 'announcements';
    protected $fillable = [
        'school_id',
        'created_by',
        'title',
        'content',
        'target_roles',
        'priority',
        'published_at',
        'expires_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'target_roles' => 'array',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
