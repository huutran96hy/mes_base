<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'plan_start_date', 'plan_end_date', 'status', 'remarks'];

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class, 'order_id');
    }

    public function planSteps()
    {
        return $this->hasMany(PlanStep::class, 'plan_id');
    }
}
