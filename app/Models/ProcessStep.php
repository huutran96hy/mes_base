<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    use HasFactory;

    protected $fillable = ['process_id', 'step_name', 'description', 'sequence_order', 'default_duration'];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function planSteps()
    {
        return $this->hasMany(PlanStep::class);
    }

    public function productionHistory()
    {
        return $this->hasMany(ProductionHistory::class);
    }
}
