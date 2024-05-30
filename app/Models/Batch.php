<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'batch_number', 'start_date', 'end_date', 'quantity', 'status'];

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }

    public function productionHistory()
    {
        return $this->hasMany(ProductionHistory::class);
    }
}
