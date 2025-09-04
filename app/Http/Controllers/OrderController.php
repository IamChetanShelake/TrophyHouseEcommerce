<?php

namespace App\Http\Controllers;

use Log;
use PDF;
use App\Models\Page;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\cartItem;
use App\Models\PaymentItem;
use App\Models\SubCategory;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomizationRequest;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Payment::with([
            'user',
            'items.product',
            'items.variant:id,product_id,size,color,price,discounted_price',
            'items.customizationRequest:id,payment_item_id,status',
            'items.customizationRequest.messages',
            'items.designer:id,name'
        ])
            ->where('status', 'paid'); // show only paid

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $q->where(function ($qb) use ($term) {
                $qb->where('order_id', 'like', $term)
                    ->orWhere('customer_name', 'like', $term)
                    ->orWhere('customer_email', 'like', $term);
            });
        }

        $payments = $q->latest('updated_at')->paginate(20);
        // return $payments;
        // foreach ($payments as $p) {
        //      $p->order_status;
        // }
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

    public function updateDeliveryStatus(Request $request, $id)
    {

        $payment = Payment::where('id', $id)->first();
        $data = $request->validate([
            'delivery_status' => 'required'
        ]);

        $payment->delivery_status = $data['delivery_status'];
        $updated =  $payment->save();
        if ($updated) {
            return back()->with('success', 'Delivery status updated.');
        } else {
            return back()->with('error', 'Delivery cannot status updated.');
        }
    }



    //     public function updateDeliveryStatus(Request $request, PaymentItem $paymentItem)
    //     {
    //         $data = $request->validate([
    //             'delivery_status' => 'required|in:pending,ready_to_pickup,delivered'
    //         ]);

    //         // if item has a customization, ensure it's approved before marking ready/delivered

    // if ($paymentItem->customizationRequest) {
    //     $hasApprovedMessage = $paymentItem->customizationRequest
    //         ->messages()
    //         ->where('is_approved', 1)
    //         ->exists();

    //     if (!$hasApprovedMessage) {
    //         return back()->with('error', 'Customization is not approved yet.');
    //     }
    // }
    //         // if ($paymentItem->customizationRequest && $paymentItem->customizationRequest->status !== 'approved') {
    //         //     return back()->with('error', 'Customization is not approved yet.');
    //         // }


    //         $paymentItem->delivery_status = $data['delivery_status'];
    //         $paymentItem->save();

    //         return back()->with('success', 'Delivery status updated.');
    //     }

    public function viewOrder($id)
    {
        $order = Order::with('user', 'orderItems.product', 'product')->find($id);
        // return $order;
        return view('admin.Orders.viewOrder', compact('order'));
    }

    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        // Get user's payment history with items
        $payments = Payment::with([
            'paymentItems.product',
            'paymentItems.variant',
            'paymentItems.customizationRequest',
            'paymentItems.customizationRequest.messages'
        ])
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
            }
        }


        // Get common view data for layout
        $commonData = [
            'categories' => AwardCategory::with('products')->get(),
            'cart_items' => cartItem::where('user_id', Auth::id())->count(),
            'pages' => Page::all(),
            'wishlist_count' => WishlistItem::where('user_id', Auth::id())->count(),
        ];
        $customization_request = CustomizationRequest::where('user_id', Auth::id())->get();
        $customizationRequest = CustomizationRequest::with('designer')
            ->where('user_id', Auth::id())
            ->first();
                                                        $custom = $customization_request->firstWhere(
                                                            'payment_item_id',
                                                            $payment->id,
                                                        );

                                                        $customization = Auth::user()
                                                            ->customizationRequests()
                                                            ->where('payment_item_id', $payment->id)
                                                            ->where('status', 'pending')
                                                            ->first();
                                                        
                                                        $customizationApproved = Auth::user()
                                                            ->customizationRequests()
                                                            ->where('payment_item_id', $payment->id)
                                                            ->where('status', 'approved')
                                                            ->first();
                                                        if (isset($customizationApproved)) {
                                                        } else {
                                                            $customizationApproved = null;
                                                        }
                                                
       
        return view('website.orders.my-orders', array_merge($commonData, [
            'payments' => $payments,
            'customization_request' => $customization_request,
            'customizationRequest' => $customizationRequest,
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
            Log::error('Error in getOrderProducts', [
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
            // return $payment;
        // Get designer IDs who have already accepted this order
        $acceptedDesignerIds = $payment->items
            ->pluck('customizationRequest')
            ->filter(fn($c) => $c && $c->status === 'accepted')
            ->pluck('designer_id')
            ->unique()
            ->toArray();

        // Get all designers except those who already accepted
        $designers = User::where('role', 2)
            ->whereNotIn('id', $acceptedDesignerIds)
            ->get();

        return view('admin.orders.products', [
            'orderId' => $orderId,
            'products' => $payment->items,
            'designers' => $designers
        ]);
    }

    public function productChat($productId)
    {
        $productItem = PaymentItem::with([
            'payment',  // make sure payment relation exists in PaymentItem model
            'customizationRequest.messages'
        ])->findOrFail($productId);

        return view('admin.orders.partials.product_chat', [
            'messages' => $productItem->customizationRequest ? $productItem->customizationRequest->messages : collect(),
            'payment'  => $productItem->payment, // pass payment object
        ]);
    }

    public function createorder()
    {
        $categories = AwardCategory::all();
        // $occasions = Occasion::all();
        $subcategories = SubCategory::all();
        // return $subcategories;
        $products = Product::all();
        $productsizes = ProductVariant::get();
        return view('admin.Orders.createOrder', compact('categories', 'subcategories', 'products', 'productsizes'));
    }


    // Get subcategories for a category
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->select('id', 'title') // important: 'title' for dropdown
            ->get();

        return response()->json($subcategories);
    }


    public function getProducts($subCategoryId)
    {

        $products = Product::where('sub_category_id', $subCategoryId)
            ->select('id', 'title', 'image') // image column include
            ->get();


        return response()->json($products);
    }

    public function getSizes($productId)
    {
        $sizes = ProductVariant::where('product_id', $productId)
            ->select('id', 'size', 'price', 'discounted_price', 'quantity')
            ->get();

        return response()->json($sizes);
    }

    public function checkUser(Request $request)
    {
        $exists = User::where('email', $request->email)->first();

        if ($exists) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }



    // public function offlineorderstore(Request $request)
    // {
    //     return $request->all();
    //     DB::beginTransaction();

    //     try {
    //         // 1. Check if user exists
    //         $user = User::where('mobile', $request->mobile)
    //             ->orWhere('email', $request->email)
    //             ->first();

    //         if (!$user) {
    //             // New User
    //             $user = User::create([
    //                 'name'     => $request->name,
    //                 'email'    => $request->email,
    //                 'mobile'   => $request->mobile,
    //                 'password' => Hash::make($request->password),
    //                 'status'   => 1,
    //             ]);
    //         }

    //         // 2. Payment Table Entry
    //         $payment = Payment::create([
    //             'customer_id'    => $user->id,
    //             'customer_name'  => $user->name,
    //             'customer_phone' => $user->mobile,
    //             'customer_email' => $user->email,
    //             'amount'         => $request->paidamount,
    //             'status'         => 'paid',
    //             'payment_mode'   => $request->payment_mode,
    //         ]);

    //         // 3. Payment Item Table Entry
    //         if ($request->product && is_array($request->product)) {
    //             foreach ($request->product as $key => $productId) {
    //                 PaymentItem::create([
    //                     'payment_id'   => $payment->id,
    //                     'user_id'      => $user->id,
    //                     'product_id'   => $productId,
    //                     'variant_id'   => $request->size[$key],
    //                     'quantity'     => $request->qty[$key],
    //                     'unit_price'   => $request->disc_rate[$key],
    //                     'total_price'  => $request->total[$key],
    //                 ]);
    //             }
    //         }

    //         DB::commit();

    //         return redirect()->route('orders')->with('success', 'Order created successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    //     }
    // }



    public function offlineorderstore(Request $request)
    {
        //  DB::beginTransaction();


        // return $request->all();

        // 1. Check if user exists
        $user = User::Where('email', $request->email)
            ->first();

        if (!$user) {
            // New User (Object + save)
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->mobile   = $request->mobile;
            $user->password = Hash::make($request->password);
            $user->status   = 0;
            $user->save();
        }

        // 2. Payment Table Entry (Object + save)
        $payment = new Payment();
        $payment->order_id = 'THOFF_' . time() . '_' . $user->id;
        $payment->customer_id    = $user->id;
        $payment->customer_name  = $user->name;
        $payment->customer_phone = $user->mobile;
        $payment->customer_email = $user->email;
        $payment->bill = $request->status;
        $payment->amount         = $request->paidamount;
        $payment->status         = 'paid';
        $payment->payment_mode   = $request->payment_mode;
        $payment->save();

        // 3. Payment Item Table Entry (Object + save)
        if ($request->product && is_array($request->product)) {
            foreach ($request->product as $key => $productId) {
                $paymentItem = new PaymentItem();
                $paymentItem->payment_id   = $payment->id;
                $paymentItem->payment_order_id   = $payment->order_id;
                $paymentItem->user_id      = $user->id;
                $paymentItem->product_id   = $productId;
                $paymentItem->variant_id   = $request->size[$key];
                $paymentItem->quantity     = $request->qty[$key];
                $paymentItem->unit_price   = $request->disc_rate[$key];
                $paymentItem->total_price  = $request->total[$key];
                $paymentItem->save();
            }
        }

        // DB::commit();

        return redirect()->route('orders')->with('success', 'Order created successfully!');
    }
}
