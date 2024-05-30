<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'process_id', 'start_date', 'end_date', 'quantity', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function productionPlans()
    {
        return $this->hasMany(ProductionPlan::class);
    }

    public function productionHistory()
    {
        return $this->hasMany(ProductionHistory::class);
    }
}
