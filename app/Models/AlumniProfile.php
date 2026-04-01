<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AlumniProfile extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'alumni_profiles';

    protected $fillable = [
        'school_id',
        'user_id',
        'company_name',
        'designation',
        'industry',
        'bio',
        'status',
    ];
}
