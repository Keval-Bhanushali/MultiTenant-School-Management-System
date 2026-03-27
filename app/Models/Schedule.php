<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
