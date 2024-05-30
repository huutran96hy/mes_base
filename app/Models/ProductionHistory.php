<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'batch_id', 'lot_id', 'step_id', 'process_id', 'start_time', 'end_time',
        'quantity_completed', 'quantity_NG', 'status', 'operator_id', 'equipment_id', 'material_used', 'remarks'
    ];

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class, 'order_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class, 'lot_id');
    }

    public function processStep()
    {
        return $this->belongsTo(ProcessStep::class, 'step_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
