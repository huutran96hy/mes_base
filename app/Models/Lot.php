<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = ['batch_id', 'parent_lot_id', 'lot_number', 'production_date', 'expiry_date', 'quantity', 'status'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function parentLot()
    {
        return $this->belongsTo(Lot::class, 'parent_lot_id');
    }

    public function childLots()
    {
        return $this->hasMany(Lot::class, 'parent_lot_id');
    }

    public function productionHistory()
    {
        return $this->hasMany(ProductionHistory::class);
    }

    public function qualityChecks()
    {
        return $this->hasMany(QualityCheck::class);
    }

    public function lotSplits()
    {
        return $this->hasMany(LotSplit::class, 'original_lot_id');
    }

    public function lotSplitsNew()
    {
        return $this->hasMany(LotSplit::class, 'new_lot_id');
    }
}
