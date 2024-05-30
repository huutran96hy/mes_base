<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanStep extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'step_id', 'equipment_id', 'plan_start_time', 'plan_end_time', 'planned_quantity'];

    public function productionPlan()
    {
        return $this->belongsTo(ProductionPlan::class, 'plan_id');
    }

    public function processStep()
    {
        return $this->belongsTo(ProcessStep::class, 'step_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
