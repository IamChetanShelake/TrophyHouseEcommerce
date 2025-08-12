<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OccasionProduct;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
   protected $guarded = [];

   protected $casts = [
    'color' => 'array', // this will automatically json_decode it
];

    // Relationship: Variant belongs to one product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function occProducts()
    {
        return $this->belongsTo(OccasionProduct::class);
    }

}
