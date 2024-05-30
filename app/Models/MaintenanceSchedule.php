<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['equipment_id', 'maintenance_date', 'next_maintenance_date', 'remarks'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
