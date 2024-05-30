<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id','product_name', 'description', 'category_id'];
    public $incrementing = false;
    protected $keyType = 'string';
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function boms()
    {
        return $this->hasMany(Bom::class);
    }

    public function productionOrders()
    {
        return $this->hasMany(ProductionOrder::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
