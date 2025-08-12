<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OccasionProduct;
use Illuminate\Database\Eloquent\Model;

class productImage extends Model
{
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
{
    return url('product_images/' . $this->image_path);
}

    protected $guarded=[];

    public function product()
{
    return $this->belongsTo(OccasionProduct::class, 'occasion_product_id');
}
  public function prod()
{
    return $this->belongsTo(Product::class);
}
}
