<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'age', 'gender', 'phone', 'address',
        'reference_dr_name', 'visit_date', 'notes', 'lab_id', 'photo',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function latestBooking()
    {
        return $this->hasOne(Booking::class)->latestOfMany();
    }
}
