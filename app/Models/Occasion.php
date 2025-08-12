<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OccasionProduct;

class Occasion extends Model
{
    protected $guarded=[];

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
   public function occproducts()
{
    return $this->hasMany(OccasionProduct::class,'occasion_id');
}
}
