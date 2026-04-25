<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'assigned_to'];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
