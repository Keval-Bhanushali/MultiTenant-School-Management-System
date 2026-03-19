<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Teacher extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'teachers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject_specialization',
    ];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }
}
