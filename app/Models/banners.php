<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class banners extends Model
{
    protected $fillable = [
        'title1',
        'description1',
        'image1',
        'title2',
        'description2',
        'image2',
        'title3',
        'description3',
        'image3'
    ];
    protected $table = 'banners';
}
