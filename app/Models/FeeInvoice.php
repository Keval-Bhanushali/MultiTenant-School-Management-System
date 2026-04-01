<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class FeeInvoice extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'fee_invoices';

    protected $fillable = [
        'school_id',
        'student_name',
        'invoice_number',
        'amount',
        'due_date',
        'status',
    ];
}
