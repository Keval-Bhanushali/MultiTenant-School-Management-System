<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PayrollRecord extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'payroll_records';

    protected $fillable = [
        'school_id',
        'staff_member_name',
        'month',
        'gross_salary',
        'deductions',
        'net_salary',
        'status',
    ];
}
