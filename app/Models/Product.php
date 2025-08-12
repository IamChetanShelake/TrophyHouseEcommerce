<?php

namespace App\Models;

use App\Models\Order;
use App\Models\SubCategory;
use App\Models\productImage;
use App\Models\WishlistItem;
use App\Models\AwardCategory;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     // Append image_url to JSON response
    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('product_images/' . $this->image) : null;
    }

    // Optionally hide the raw image column
    protected $hidden = ['image'];
    protected $guarded = [];

    public function variants()
{
    return $this->hasMany(ProductVariant::class);
}

   public function category()
{
    return $this->belongsTo(AwardCategory::class);      
}

public function subcategory() {
    return $this->belongsTo(SubCategory::class,'sub_category_id'); //  product belongzzz
}
public function cartItems() {
    return $this->hasMany(SubCategory::class,'sub_category_id');    //product has many 
}
public function orders() {
    return $this->belongsToMany(Order::class);    //product has many 
}

   public function wishlistItems()
{
    return $this->hasMany(WishlistItem::class); //one user can have many wishlist items
}
    public function images()
    {
        return $this->hasMany(productImage::class); //one product can have many images
    }

}
