<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = ['operator_name', 'contact_info'];

    public function productionHistory()
    {
        return $this->hasMany(ProductionHistory::class);
    }
}
