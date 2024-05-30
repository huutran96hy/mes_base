<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id', 'step_id', 'check_type', 'start_time', 'end_time', 'result', 'inspector_id', 'remarks'
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function processStep()
    {
        return $this->belongsTo(ProcessStep::class, 'step_id');
    }

    public function inspector()
    {
        return $this->belongsTo(Inspector::class, 'inspector_id');
    }

    public function qualityCheckDetails()
    {
        return $this->hasMany(QualityCheckDetail::class, 'check_id');
    }
}
