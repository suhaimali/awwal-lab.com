<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'test_type',
        'name',
        'phone',
        'booking_date',
        'booking_time',
        'amount',
        'status',
        'notes',
        'payment_method',
        'total_amount',
        'discount',
        'final_payable',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
