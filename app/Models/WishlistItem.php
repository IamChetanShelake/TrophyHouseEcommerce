<?php

namespace App\Models;

use App\Models\Occasion;
use App\Models\OccasionProduct;
use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    // // Append image_url to JSON response
    // protected $appends = ['image_url'];

    // // Accessor to get full image URL
    // public function getImageUrlAttribute()
    // {
    //     return $this->image ? asset('product_images/' . $this->image) : null;
    // }

    // // Optionally hide the raw image column
    // protected $hidden = ['image'];
  
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',          // <-- NEW
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

        public function occProducts()
{
    return $this->belongsTo(OccasionProduct::class);
}
}
