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
}
