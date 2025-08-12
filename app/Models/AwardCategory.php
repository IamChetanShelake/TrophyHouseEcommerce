<?php

namespace App\Models;

use App\Models\Occasion;
use App\Models\OccasionProduct;
use Illuminate\Database\Eloquent\Model;

class AwardCategory extends Model
{
    // Append image_url to JSON response
    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('category_images/' . $this->image) : null;
    }

    // Optionally hide the raw image column
    protected $hidden = ['image'];
    
    protected $table = 'category';

    protected $guarded = [];

    public function products()
{
    return $this->hasMany(Product::class,'category_id');
}
    public function occProducts()
{
    return $this->hasMany(OccasionProduct::class,'category_id');
}

public function subCategory(){
    return $this->hasMany(SubCategory::class); //parent MOdel 
}

public function subcategories()
{
    return $this->hasMany(SubCategory::class,'category_id');
}

}
