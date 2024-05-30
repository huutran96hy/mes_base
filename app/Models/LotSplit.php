<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotSplit extends Model
{
    use HasFactory;

    protected $fillable = ['original_lot_id', 'new_lot_id', 'split_quantity', 'split_date'];

    public function originalLot()
    {
        return $this->belongsTo(Lot::class, 'original_lot_id');
    }

    public function newLot()
    {
        return $this->belongsTo(Lot::class, 'new_lot_id');
    }
}
