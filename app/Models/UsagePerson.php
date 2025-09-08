<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsagePerson extends Model
{
    protected $gaurded = [];
    public function usages()
    {
        return $this->hasMany(Usage::class, 'usage_person_id');
    }
}
