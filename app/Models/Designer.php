<?php

// app/Models/Designer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Designer extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'mobile_no', 'password', 'birthday', 'designation', 'image'];

    protected $hidden = ['password'];
}
