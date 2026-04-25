<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'test_type_id',
        'parameter_name',
        'category',
        'result_value',
        'normal_range',
        'unit',
        'remarks',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function testType()
    {
        return $this->belongsTo(TestType::class);
    }
}
