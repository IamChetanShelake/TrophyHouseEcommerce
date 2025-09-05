<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Team;
use App\Models\User;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Models\ProductionTask;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $products = Product::count();
        $testimonials = Testimonial::count();
        $teams = Team::count();
        $pages = Page::count();
        $awardCategories = AwardCategory::count();
        $subCategories = SubCategory::count();
        $users = User::count();
         $tasks = ProductionTask::with(['product', 'payment', 'paymentItem', 'assignedUser'])
        ->orderBy('created_at', 'desc')
        ->get();
        return view('admin.home',compact(['products','testimonials','teams','pages','awardCategories','subCategories','users','tasks']));
    }

   
}
