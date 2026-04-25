<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_id',
        'booking_id',
        'report_file',
        'status',
        'created_at',
        'updated_at',
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function reportItems()
    {
        return $this->hasMany(ReportItem::class);
    }
}
