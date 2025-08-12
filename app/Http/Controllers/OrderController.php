<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function viewOrder($id){
    $order = Order::with('user','orderItems.product','product')->find($id);
    // return $order;
    return view('admin.Orders.viewOrder',compact('order'));
}
}
