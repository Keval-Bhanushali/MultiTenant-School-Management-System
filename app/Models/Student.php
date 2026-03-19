<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'students';

    protected $fillable = [
        'name',
        'email',
        'roll_number',
        'class_id',
        'guardian_name',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
