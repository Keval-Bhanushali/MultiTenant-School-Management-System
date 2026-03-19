<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class FileDocument extends Model
{
    protected $collection = 'file_documents';
    protected $fillable = [
        'school_id',
        'uploader_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'document_type',
        'description',
        'shared_with_roles',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'shared_with_roles' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
