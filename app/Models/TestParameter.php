<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestParameter extends Model
{
    protected $fillable = ['name', 'category', 'unit', 'normal_range', 'status'];
}
