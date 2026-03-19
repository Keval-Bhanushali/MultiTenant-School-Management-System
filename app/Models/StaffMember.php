<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class StaffMember extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'staff_members';

    protected $fillable = [
        'school_id',
        'name',
        'email',
        'phone',
        'department',
        'designation',
        'user_role',
    ];
}
