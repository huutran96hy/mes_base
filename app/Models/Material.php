<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['material_name', 'description', 'unit'];

    public function bomItems()
    {
        return $this->hasMany(BomItem::class);
    }
}
