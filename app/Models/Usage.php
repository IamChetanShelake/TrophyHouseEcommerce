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
    public function usagePerson()
    {
        return $this->belongsTo(UsagePerson::class, 'usage_person_id');
    }
}
