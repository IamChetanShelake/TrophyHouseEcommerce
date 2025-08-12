<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function index()
    {
        return view('admin.banners.index');
    }
}
