<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function myOrders($user_id)
    {
        // Fetch orders with related products & variants
        $orders = Payment::with([
            'paymentItems.product',
            'paymentItems.variant'
        ])
        ->where('user_id', $user_id)
        ->orderBy('create_at', 'desc')
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'My Orders fetched successfully',
            'data' => $orders
        ]);
    }
}
