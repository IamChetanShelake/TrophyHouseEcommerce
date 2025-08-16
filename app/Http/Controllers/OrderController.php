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
     public function index(Request $request)
    {
        $q = Payment::with([
                'user:id,name,email,mobile',
                'items.product',
                'items.variant:id,product_id,size,color,price,discounted_price',
                'items.customizationRequest:id,status',
                'items.designer:id,name'
            ])
            ->where('status', 'paid'); // show only paid

        if ($request->filled('q')) {
            $term = '%'.$request->q.'%';
            $q->where(function($qb) use ($term) {
                $qb->where('order_id', 'like', $term)
                   ->orWhere('customer_name', 'like', $term)
                   ->orWhere('customer_email', 'like', $term);
            });
        }

        $payments = $q->latest('updated_at')->paginate(20);

        return view('admin.Orders.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load([
            'user:id,name,email,mobile',
            'items.product',
            'items.variant',
            'items.customizationRequest.messages.sender',
            'items.designer'
        ]);

        return view('admin.payments.show', compact('payment'));
    }

    public function updateDeliveryStatus(Request $request, PaymentItem $paymentItem)
    {
        $data = $request->validate([
            'delivery_status' => 'required|in:pending,ready_to_pickup,delivered'
        ]);

        // if item has a customization, ensure it's approved before marking ready/delivered
        if ($paymentItem->customizationRequest && $paymentItem->customizationRequest->status !== 'approved') {
            return back()->with('error', 'Customization is not approved yet.');
        }

        $paymentItem->delivery_status = $data['delivery_status'];
        $paymentItem->save();

        return back()->with('success', 'Delivery status updated.');
    }

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
        $payments = Payment::with(['paymentItems.product', 'paymentItems.variant','paymentItems.customizationRequest',
        'paymentItems.customizationRequest.messages'  ])
            ->where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        //approval checks
        // Add is_approved property dynamically
foreach ($payments as $payment) {
    foreach ($payment->paymentItems as $item) {
        $item->is_approved = $item->customizationRequest
            ? $item->customizationRequest->messages
                ->where('is_approved', 1)
                ->count() > 0
            : false;
           
    }}
        
        
        // Get common view data for layout
        $commonData = [
            'categories' => AwardCategory::with('products')->get(),
            'cart_items' => cartItem::where('user_id', Auth::id())->count(),
            'pages' => Page::all(),
            'wishlist_count' => WishlistItem::where('user_id', Auth::id())->count(),
        ];
        
        return view('website.orders.my-orders', array_merge($commonData, [
            'payments' => $payments,
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
  


public function getUserDetails($orderId)
{
    try {
        $payment = Payment::with('user')->where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        return response()->json([
            'name'  => $payment->user->name  ?? $payment->customer_name,
            'email' => $payment->user->email ?? $payment->customer_email,
            'phone' => $payment->user->mobile ?? $payment->customer_phone,
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error in getUserDetails', [
            'order_id' => $orderId,
            'message' => $e->getMessage()
        ]);
        return response()->json(['error' => 'Server error while fetching user details'], 500);
    }
}

public function getOrderProducts($orderId)
{
    try {
        $payment = Payment::with([
            'items.product',
            'items.variant',
            'items.designer',
            'items.customizationRequest.messages', 
        ])->where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        $data = $payment->items->map(function ($it) {
            return [
                'product'  => ['name' => $it->product->name ?? 'N/A'],
                'variant'  => $it->variant ? [
                    'size'  => $it->variant->size,
                    'color' => $it->variant->color,
                ] : null,
                'quantity' => $it->quantity,
                'unit_price' => $it->unit_price,
                'designer' => $it->designer ? ['name' => $it->designer->name] : null,
            ];
        });

        return response()->json($data, 200);

    } catch (\Exception $e) {
        \Log::error('Error in getOrderProducts', [
            'order_id' => $orderId,
            'message' => $e->getMessage()
        ]);
        return response()->json(['error' => 'Server error while fetching products'], 500);
    }
}
public function showOrderProducts($orderId)
{
    $payment = Payment::with([
        'items.product',
        'items.variant',
        'items.designer',
        'items.customizationRequest.messages', 
    ])->where('order_id', $orderId)->firstOrFail();
        // return $payment->items;
    return view('admin.orders.products', [
        'orderId' => $orderId,
        'products' => $payment->items
    ]);
}

public function productChat($productId) {
      $productItem = PaymentItem::with([
        'payment',  // make sure payment relation exists in PaymentItem model
        'customizationRequest.messages'
    ])->findOrFail($productId);

    return view('admin.orders.partials.product_chat', [
        'messages' => $productItem->customizationRequest ? $productItem->customizationRequest->messages : collect(),
        'payment'  => $productItem->payment, // pass payment object
    ]);
}





}