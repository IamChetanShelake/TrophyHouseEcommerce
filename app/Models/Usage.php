<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    protected $guarded = [];
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
