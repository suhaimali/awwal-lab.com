<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_id',
        'bill_no',
        'lab_id',
        'patient_id',
        'tests',
        'booking_date',
        'booking_time',
        'reporting_date',
        'amount',
        'total_amount',
        'discount',
        'advance_amount',
        'balance_amount',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'tests' => 'array',
        'booking_date' => 'date',
        'reporting_date' => 'date',
        'total_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }
}
