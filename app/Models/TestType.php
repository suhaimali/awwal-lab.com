<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_code',
        'name',
        'category',
        'price',
        'parameters',
        'status',
        'normal_range',
        'unit',
        'lab_id',
        'custom_field',
        'color',
        'notes'
    ];

    protected $casts = [
        'parameters' => 'array',
        'price' => 'decimal:2',
    ];
}
