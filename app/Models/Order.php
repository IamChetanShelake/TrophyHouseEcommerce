<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Occasion;
use App\Models\OrderItem;
use App\Models\OccasionProduct;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderItems() {
    return $this->hasMany(OrderItem::class);    // an order can have many products
}
    public function user() {
    return $this->belongsTo(User::class);    // an order can have many products
}

public function product(){
    return $this->belongsTo(Product::class);
}
    public function occProducts()
{
    return $this->belongsTo(OccasionProduct::class);
}
}