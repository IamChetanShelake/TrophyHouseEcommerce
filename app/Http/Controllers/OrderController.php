<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\AwardCategory;
use App\Models\cartItem;
use App\Models\Page;
use App\Models\WishlistItem;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;


class OrderController extends Controller
{
    public function viewOrder($id){
        $order = Order::with('user','orderItems.product','product')->find($id);
        // return $order;
        return view('admin.Orders.viewOrder',compact('order'));
    }

    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        // Get user's payment history with items
        $payments = Payment::with(['paymentItems.product', 'paymentItems.variant'])
            ->where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Get common view data for layout
        $commonData = [
            'categories' => AwardCategory::with('products')->get(),
            'cart_items' => cartItem::where('user_id', Auth::id())->count(),
            'pages' => Page::all(),
            'wishlist_count' => WishlistItem::where('user_id', Auth::id())->count(),
        ];

        return view('website.orders.my-orders', array_merge($commonData, [
            'payments' => $payments
        ]));
    }

    public function orderDetails($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view order details.');
        }

        // Get order details for the authenticated user only
        $order = Order::with(['product', 'orderItems.product'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect()->route('my.orders')->with('error', 'Order not found.');
        }

        // Get common view data for layout
        $commonData = [
            'categories' => AwardCategory::with('products')->get(),
            'cart_items' => cartItem::where('user_id', Auth::id())->count(),
            'pages' => Page::all(),
            'wishlist_count' => WishlistItem::where('user_id', Auth::id())->count(),
        ];

        return view('website.orders.order-details', array_merge($commonData, [
            'order' => $order
        ]));
    }
//     public function downloadBill($order_id)
// {
//     $payment = Payment::with(['paymentItems.product', 'paymentItems.variant'])
//         ->where('customer_id', Auth::id())
//         ->where('order_id', $order_id)
//         ->firstOrFail();

//     $pdf = PDF::loadView('website.orders.bill-pdf', compact('payment'))
//               ->setPaper('a4');

//     // Preview in browser:
//     return $pdf->stream('Order-'.$payment->order_id.'.pdf');
    
//     // If you want direct download:
//     // return $pdf->download('Order-'.$payment->order_id.'.pdf');
// }




    public function paymentDetails($order_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view payment details.');
        }

        // Get payment details for the authenticated user only
        $payment = Payment::with(['paymentItems.product', 'paymentItems.variant'])
            ->where('customer_id', Auth::id())
            ->where('order_id', $order_id)
            ->first();

        if (!$payment) {
            return redirect()->route('my.orders')->with('error', 'Payment not found.');
        }

        // Get common view data for layout
        $commonData = [
            'categories' => AwardCategory::with('products')->get(),
            'cart_items' => cartItem::where('user_id', Auth::id())->count(),
            'pages' => Page::all(),
            'wishlist_count' => WishlistItem::where('user_id', Auth::id())->count(),
        ];

        return view('website.orders.payment-details', array_merge($commonData, [
            'payment' => $payment
        ]));
    }
}