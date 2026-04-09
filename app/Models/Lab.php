<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_name',
        'description',
    ];

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
