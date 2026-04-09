<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lab_id',
        'status',
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}
