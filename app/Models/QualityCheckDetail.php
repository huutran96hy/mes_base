<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityCheckDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_id', 'quality_criteria', 'measurement', 'result', 'unit', 'standard_value', 'remarks'
    ];

    public function qualityCheck()
    {
        return $this->belongsTo(QualityCheck::class, 'check_id');
    }
}
