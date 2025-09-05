<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(MaterialType::class, 'category_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'material_id');
    }

    // ✅ current_stock accessor
    // protected $appends = ['current_stock'];

    // public function getCurrentStockAttribute()
    // {
    //     return round($this->stock_in - $this->stock_out);
    // }

    protected static function booted()
    {
        static::saving(function ($material) {
            $material->current_stock = (int)$material->stock_in - (int)$material->stock_out;
        });
    }
}
