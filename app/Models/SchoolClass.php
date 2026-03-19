<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SchoolClass extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'classes';

    protected $fillable = [
        'name',
        'section',
        'capacity',
        'teacher_id',
        'room_number',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
