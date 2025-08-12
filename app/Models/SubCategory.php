<?php

namespace App\Models;

use App\Models\Occasion;
use App\Models\OccasionProduct;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    // Append image_url to JSON response
    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('sub-category_images/' . $this->image) : null;
    }

    // Optionally hide the raw image column
    protected $hidden = ['image'];
    protected $guarded = [];
    
    public function category(){
        return $this->belongsTo(AwardCategory::class,'category_id'); //this model  holds foreign key | child model
    }

    public function products(){
        return $this->hasMany(Product::class);  //another model holds foreign key | parent model
    }
        public function occProducts()
{
    return $this->hasMany(OccasionProduct::class,'category_id');
}
}
