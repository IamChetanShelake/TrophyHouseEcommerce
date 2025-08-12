<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Occasion;
use App\Models\SubCategory;
use App\Models\productImage;
use App\Models\WishlistItem;
use App\Models\AwardCategory;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;

class OccasionProduct extends Model
{
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'occasion_product_id');
    }
    public function category()
    {
        return $this->belongsTo(AwardCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id'); //  product belongzzz
    }
    public function cartItems()
    {
        return $this->hasMany(SubCategory::class, 'sub_category_id');    //product has many
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class);    //product has many
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class); //one product can have many wishlist items
    }
    public function images()
    {
        return $this->hasMany(productImage::class, 'occasion_product_id'); //one product can have many images
    }
    public function occasion()
    {
        return $this->belongsTo(Occasion::class, 'occasion_id'); //
    }

    protected $guarded = [];
    
    protected $table = 'occasional_products';
}
