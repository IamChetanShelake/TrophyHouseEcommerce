<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Support\Facades\Log;
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
use App\Models\PaymentDeliveryStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomizationRequest;


class OrderController extends Controller
{
    
    public function index(Request $request, $status = null)
    {
        $q = Payment::with([
            'user',
            'items.product',
            'items.variant:id,product_id,size,color,price,discounted_price',
            'items.customizationRequest:id,payment_item_id,status',
            'items.customizationRequest.messages',
            'items.customizationRequest.designer',
            'items.designer:id,name'
        ])->where('status', 'paid'); // show only paid

        // filter by delivery status if provided
        if ($status) {
            $q->where('delivery_status', $status);
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $q->where(function ($qb) use ($term) {
                $qb->where('order_id', 'like', $term)
                    ->orWhere('customer_name', 'like', $term)
                    ->orWhere('customer_email', 'like', $term);
            });
        }



        $payments = $q->latest('updated_at')->paginate(20);

        // Get all designers (role = 2)
        $designers = User::where('role', 2)
            ->orderBy('name')
            ->get();


        return view('admin.Orders.index', compact('payments', 'status', 'designers'));
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

        PaymentDeliveryStatus::create([
            'payment_id' => $payment->id,
            'delivery_status' => $payment->delivery_status,
            'changed_at' => now(),
        ]);

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

        // Define common data (always needed)
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

        if ($payments->isNotEmpty()) {
            // Approval checks
            foreach ($payments as $payment) {
                foreach ($payment->paymentItems as $item) {
                    $item->is_approved = $item->customizationRequest
                        ? $item->customizationRequest->messages
                        ->where('is_approved', 1)
                        ->count() > 0
                        : false;
                }

                // Fetch customization details safely
                $custom = $customization_request->firstWhere(
                    'payment_item_id',
                    $payment->id,
                );

                $customization = CustomizationRequest::where('user_id', Auth::id())
                    ->where('payment_item_id', $payment->id)
                    ->where('status', 'pending')
                    ->first();

                $customizationApproved = CustomizationRequest::where('user_id', Auth::id())
                    ->where('payment_item_id', $payment->id)
                    ->where('status', 'approved')
                    ->first();

                if (!isset($customizationApproved)) {
                    $customizationApproved = null;
                }
            }
        } else {
            $payments = collect(); // empty collection (better than [])
        }
        // return $payments;
        return view('website.orders.my-orders', array_merge($commonData, [
            'payments' => $payments,
            'customization_request' => $customization_request,
            'customizationRequest' => $customizationRequest,
        ]));
    }


    //my method
    // public function myOrders()
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login')->with('error', 'Please login to view your orders.');
    //     }

    //     // Get user's payment history with items
    //     $payments = Payment::with([
    //         'paymentItems.product',
    //         'paymentItems.variant',
    //         'paymentItems.customizationRequest',
    //         'paymentItems.customizationRequest.messages'
    //     ])
    //         ->where('customer_id', Auth::id())
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     //approval checks
    //     // Add is_approved property dynamically
    //     if($payments->isNotEmpty()){

    //     foreach ($payments as $payment) {
    //         foreach ($payment->paymentItems as $item) {
    //             $item->is_approved = $item->customizationRequest
    //                 ? $item->customizationRequest->messages
    //                 ->where('is_approved', 1)
    //                 ->count() > 0
    //                 : false;
    //         }
    //     }


    //     // Get common view data for layout
    //     $commonData = [
    //         'categories' => AwardCategory::with('products')->get(),
    //         'cart_items' => cartItem::where('user_id', Auth::id())->count(),
    //         'pages' => Page::all(),
    //         'wishlist_count' => WishlistItem::where('user_id', Auth::id())->count(),
    //     ];
    //     $customization_request = CustomizationRequest::where('user_id', Auth::id())->get();
    //     $customizationRequest = CustomizationRequest::with('designer')
    //         ->where('user_id', Auth::id())
    //         ->first();
    //                                                     $custom = $customization_request->firstWhere(
    //                                                         'payment_item_id',
    //                                                         $payment->id,
    //                                                     );

    //                                                     $customization = Auth::user()
    //                                                         ->customizationRequests()
    //                                                         ->where('payment_item_id', $payment->id)
    //                                                         ->where('status', 'pending')
    //                                                         ->first();

    //                                                     $customizationApproved = Auth::user()
    //                                                         ->customizationRequests()
    //                                                         ->where('payment_item_id', $payment->id)
    //                                                         ->where('status', 'approved')
    //                                                         ->first();
    //                                                     if (isset($customizationApproved)) {
    //                                                     } else {
    //                                                         $customizationApproved = null;
    //                                                     }
    //     }else{
    //         $payments = [];
    //     }


    //     return view('website.orders.my-orders', array_merge($commonData, [
    //         'payments' => $payments,
    //         'customization_request' => $customization_request,
    //         'customizationRequest' => $customizationRequest,
    //     ]));
    // }

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
                'image'  => $payment->user->profile_img  ?? null,
                'name'  => $payment->user->name  ?? $payment->customer_name,
                'email' => $payment->user->email ?? $payment->customer_email,
                'phone' => $payment->user->mobile ?? $payment->customer_phone,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in getUserDetails', [
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
            'items.customizationRequest.designer',
        ])->where('order_id', $orderId)->firstOrFail();

        // Get designer IDs who already accepted
        $acceptedDesignerIds = $payment->items
            ->pluck('customizationRequest')
            ->filter(fn($c) => $c && $c->status === 'accepted')
            ->pluck('designer_id')
            ->unique()
            ->toArray();

        // All other designers (optional, if needed later)
        $designers = User::where('role', 2)
            ->whereNotIn('id', $acceptedDesignerIds)
            ->get();

        return response()->json([
            'products' => $payment->items->map(function ($item) {
                $customization = $item->customizationRequest;

                return [
                    'id' => $item->id,
                    'product' => $item->product ? [
                        'id' => $item->product->id,
                        'title' => $item->product->title,
                    ] : null,
                    'variant' => $item->variant ? [
                        'id' => $item->variant->id,
                        'size' => $item->variant->size,
                        'color' => $item->variant->color,
                    ] : null,
                    'designer' => $item->designer ? [
                        'id' => $item->designer->id,
                        'name' => $item->designer->name,
                    ] : null,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'customization_request' => $customization ? [
                        'id' => $customization->id,
                        'status' => $customization->status,
                        'designer' => $customization->designer ? [
                            'id' => $customization->designer->id,
                            'name' => $customization->designer->name,
                        ] : null,
                        'messages_count' => $customization->messages->count(),
                    ] : null,
                    'is_approved' => $customization?->messages->where('is_approved', 1)->count() > 0,
                ];
            }),
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
            ->select('id', 'size', 'price', 'discounted_price', 'quantity', 'color')
            ->get()
            ->map(function ($variant) {
                // Ensure color is an array
                if (is_string($variant->color)) {
                    $variant->color = json_decode($variant->color, true) ?? [];
                } elseif (!is_array($variant->color)) {
                    $variant->color = [];
                }
                return $variant;
            });

        return response()->json($sizes);
    }

    public function checkUser(Request $request)
    {
        $exists = User::where('mobile', $request->mobile)->first();

        if ($exists) {
            return response()->json(['exists' => true, 'user_id' => $exists->id]);
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



    // public function offlineorderstore(Request $request)
    // {
    //     //return $request->all();

    //     // 1. Check if user exists
    //     $user = User::Where('mobile', $request->mobile)
    //         ->first();

    //     if (!$user) {
    //         // New User (Object + save)
    //         $user = new User();
    //         $user->name     = $request->name;
    //         $user->email    = $request->email;
    //         $user->mobile   = $request->mobile;
    //         $user->password = Hash::make($request->password);
    //         $user->status   = 0;
    //         $user->save();
    //     }

    //     // 2. Calculate making charges based on customized products
    //     $makingCharges = 0;
    //     $customizedQuantities = [];

    //     if ($request->product && is_array($request->product)) {
    //         foreach ($request->product as $key => $productId) {
    //             $isCustomized = isset($request->customization[$key]) && $request->customization[$key] == 1;
    //             if ($isCustomized) {
    //                 $customizedQuantities[] = $request->qty[$key];
    //             }
    //         }
    //     }

    //     // Calculate making charges based on total customized quantity
    //     if (!empty($customizedQuantities)) {
    //         $totalCustomizedQty = array_sum($customizedQuantities);

    //         if ($totalCustomizedQty >= 1 && $totalCustomizedQty <= 9) {
    //             $makingCharges = $totalCustomizedQty * 50;
    //         } elseif ($totalCustomizedQty >= 10 && $totalCustomizedQty <= 24) {
    //             $makingCharges = $totalCustomizedQty * 35;
    //         } elseif ($totalCustomizedQty >= 25) {
    //             $makingCharges = $totalCustomizedQty * 25;
    //         }
    //     }

    //     // 3. Calculate final amount with GST if applicable
    //     $paidAmount = $request->paidamount;
    //     $isGstBill = $request->status == 1; // GST toggle

    //     if ($isGstBill) {
    //         // GST bill: (paidamount + making_charges) * 1.18
    //         $finalAmount = ($paidAmount + $makingCharges) * 1.18;
    //     } else {
    //         // Non-GST bill: just paidamount + making_charges
    //         $finalAmount = $paidAmount + $makingCharges;
    //     }

    //     // 4. Payment Table Entry (Object + save)
    //     $payment = new Payment();
    //     $payment->order_id = 'THOFF_' . time() . '_' . $user->id;
    //     $payment->customer_id    = $user->id;
    //     $payment->customer_name  = $user->name;
    //     $payment->customer_phone = $user->mobile;
    //     $payment->customer_email = $user->email;
    //     $payment->bill = $request->status;
    //     $payment->amount         = $finalAmount;
    //     $payment->making_charges = $makingCharges;
    //     $payment->status         = 'paid';
    //     $payment->payment_mode   = $request->payment_mode;
    //     $payment->gstin   = $request->gstin;
    //     $payment->hsn_code   = $request->hsn_code;
    //     $payment->save();

    //     // 5. Payment Item Table Entry (Object + save)
    //     if ($request->product && is_array($request->product)) {
    //         foreach ($request->product as $key => $productId) {
    //             $paymentItem = new PaymentItem();
    //             $paymentItem->payment_id   = $payment->id;
    //             $paymentItem->payment_order_id   = $payment->order_id;
    //             $paymentItem->user_id      = $user->id;
    //             $paymentItem->product_id   = $productId;
    //             $paymentItem->variant_id   = $request->size[$key];
    //             $paymentItem->color        = $request->color[$key] ?? null;
    //             $paymentItem->quantity     = $request->qty[$key];
    //             $paymentItem->unit_price   = $request->disc_rate[$key];
    //             $paymentItem->total_price  = $request->total[$key];
    //             $paymentItem->cust_status  = isset($request->customization[$key]) && $request->customization[$key] == '1'  ? '1' : '0';
    //             $paymentItem->save();
    //         }
    //     }

    //     return redirect()->route('orders')->with('success', 'Order created successfully!');
    // }

    // public function offlineorderstore(Request $request)
    // {
    //     return $request->all();
    //     // 1. Check if user exists
    //     $user = User::where('mobile', $request->mobile)->first();

    //     if (!$user) {
    //         // New User (Object + save)
    //         $user = new User();
    //         $user->name     = $request->name;
    //         $user->email    = $request->email;
    //         $user->mobile   = $request->mobile;
    //         $user->password = Hash::make($request->password);
    //         $user->status   = 0;
    //         $user->save();
    //     }

    //     // 2. Calculate making charges based on customized products
    //     $makingCharges = 0;
    //     $customizedQuantities = [];
    //     $customizations = $request->customization ?? [];
    //     $index = 0;

    //     if ($request->product && is_array($request->product)) {
    //         foreach ($request->product as $key => $productId) {
    //             if ($index >= count($customizations)) {
    //                 $isCustomized = false;
    //             } else {
    //                 $value = $customizations[$index];
    //                 if ($value == 1) {
    //                     $isCustomized = true;
    //                     $index += 2; // Skip the 1 and the following 0
    //                 } else {
    //                     $isCustomized = false;
    //                     $index += 1; // Skip the 0
    //                 }
    //             }

    //             if ($isCustomized) {
    //                 $customizedQuantities[] = $request->qty[$key];
    //             }
    //         }
    //     }

    //     // Calculate making charges based on total customized quantity
    //     if (!empty($customizedQuantities)) {
    //         $totalCustomizedQty = array_sum($customizedQuantities);

    //         if ($totalCustomizedQty >= 1 && $totalCustomizedQty <= 9) {
    //             $makingCharges = $totalCustomizedQty * 50;
    //         } elseif ($totalCustomizedQty >= 10 && $totalCustomizedQty <= 24) {
    //             $makingCharges = $totalCustomizedQty * 35;
    //         } elseif ($totalCustomizedQty >= 25) {
    //             $makingCharges = $totalCustomizedQty * 25;
    //         }
    //     }

    //     // 3. Calculate final amount with GST if applicable
    //     $baseAmount = $request->totalamount;
    //     $isGstBill = $request->status == 1; // GST toggle

    //     if ($isGstBill) {
    //         // GST bill: (totalamount + making_charges) * 1.18
    //         $finalAmount = ($baseAmount + $makingCharges) * 1.18;
    //     } else {
    //         // Non-GST bill: just totalamount + making_charges
    //         $finalAmount = $baseAmount + $makingCharges;
    //     }

    //     // 4. Payment Table Entry (Object + save)
    //     $payment = new Payment();
    //     $payment->order_id = 'THOFF_' . time() . '_' . $user->id;
    //     $payment->customer_id    = $user->id;
    //     $payment->customer_name  = $user->name;
    //     $payment->customer_phone = $user->mobile;
    //     $payment->customer_email = $user->email;
    //     $payment->bill = $request->status;
    //     $payment->amount         = $finalAmount;
    //     $payment->making_charges = $makingCharges;
    //     $payment->status         = 'paid';
    //     $payment->payment_mode   = $request->payment_mode;
    //     $payment->gstin   = $request->gstin;
    //     $payment->hsn_code   = $request->hsn_code;
    //     $payment->save();

    //     // 5. Payment Item Table Entry (Object + save)
    //     if ($request->product && is_array($request->product)) {
    //         // Reset index for customization parsing in this loop
    //         $customizations = $request->customization ?? [];
    //         $index = 0;

    //         foreach ($request->product as $key => $productId) {
    //             if ($index >= count($customizations)) {
    //                 $isCustomized = false;
    //             } else {
    //                 $value = $customizations[$index];
    //                 if ($value == 1) {
    //                     $isCustomized = true;
    //                     $index += 2;
    //                 } else {
    //                     $isCustomized = false;
    //                     $index += 1;
    //                 }
    //             }

    //             $paymentItem = new PaymentItem();
    //             $paymentItem->payment_id   = $payment->id;
    //             $paymentItem->payment_order_id   = $payment->order_id;
    //             $paymentItem->user_id      = $user->id;
    //             $paymentItem->product_id   = $productId;
    //             $paymentItem->variant_id   = $request->size[$key];
    //             $paymentItem->color        = $request->color[$key] ?? null;
    //             $paymentItem->quantity     = $request->qty[$key];
    //             $paymentItem->unit_price   = $request->disc_rate[$key];
    //             $paymentItem->total_price  = $request->total[$key];
    //             $paymentItem->cust_status  = $isCustomized ? '1' : '0';
    //             $paymentItem->save();
    //         }
    //     }

    //     return redirect()->route('orders')->with('success', 'Order created successfully!');
    // }

    public function offlineorderstore(Request $request)
    {
        // return $request->all();
        // 1. Check if user exists
        $user = User::where('mobile', $request->mobile)->first();

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

        // 2. Calculate making charges based on customized products
        $makingCharges = 0;
        $customizedQuantities = [];

        // if ($request->product && is_array($request->product)) {
        //     foreach ($request->product as $key => $productId) {
        //         // Check if customization is set for this row and equals "1"
        //         $isCustomized = isset($request->customization[$key]) && $request->customization[$key] == '1';
        //         if ($isCustomized) {
        //             $customizedQuantities[] = $request->qty[$key];
        //         }
        //     }
        // }

        if ($request->product && is_array($request->product)) {
            foreach ($request->product as $key => $productId) {
                // Check if customization is set for this row and equals "1"
                $isCustomized = isset($request->customization[$key]) && $request->customization[$key] == '1';
                if ($isCustomized) {
                    $customizedQuantities[] = $request->qty[$key];
                }
            }
        }

        // Calculate making charges based on total customized quantity
        if (!empty($customizedQuantities)) {
            $totalCustomizedQty = array_sum($customizedQuantities);

            if ($totalCustomizedQty >= 1 && $totalCustomizedQty <= 9) {
                $makingCharges = $totalCustomizedQty * 50;
            } elseif ($totalCustomizedQty >= 10 && $totalCustomizedQty <= 24) {
                $makingCharges = $totalCustomizedQty * 35;
            } elseif ($totalCustomizedQty >= 25) {
                $makingCharges = $totalCustomizedQty * 25;
            }
        }

        // 3. Calculate final amount with GST if applicable
        $baseAmount = $request->totalamount;
        $isGstBill = $request->status == 1; // GST toggle

        if ($isGstBill) {
            // GST bill: (totalamount + making_charges) * 1.18
            $finalAmount = ($baseAmount + $makingCharges) * 1.18;
        } else {
            // Non-GST bill: just totalamount + making_charges
            $finalAmount = $baseAmount + $makingCharges;
        }

        // 4. Payment Table Entry (Object + save)
        $payment = new Payment();
        $payment->order_id = 'THOFF_' . time() . '_' . $user->id;
        $payment->customer_id    = $user->id;
        $payment->customer_name  = $user->name;
        $payment->customer_phone = $user->mobile;
        $payment->customer_email = $user->email;
        $payment->bill = $request->status;
        $payment->amount         = $finalAmount;
        $payment->making_charges = $makingCharges;
        $payment->status         = 'paid';
        // $payment->deliverey_date = now()->;
        $payment->payment_mode   = $request->payment_mode;
        $payment->gstin   = $request->gstin;
        $payment->hsn_code   = $request->hsn_code;
        $payment->save();

        // 5. Payment Item Table Entry (Object + save)
        if ($request->product && is_array($request->product)) {
            foreach ($request->product as $key => $productId) {
                $paymentItem = new PaymentItem();
                $paymentItem->payment_id   = $payment->id;
                $paymentItem->payment_order_id   = $payment->order_id;
                $paymentItem->user_id      = $user->id;
                $paymentItem->product_id   = $productId;
                $paymentItem->variant_id   = $request->size[$key];
                $paymentItem->color        = $request->color[$key] ?? null;
                $paymentItem->quantity     = $request->qty[$key];
                $paymentItem->unit_price   = $request->disc_rate[$key];
                $paymentItem->total_price  = $request->total[$key];
                // Set customization status based on whether the checkbox was checked
                $paymentItem->cust_status  = isset($request->customization[$key]) && $request->customization[$key] == '1' ? '1' : '0';
                if ($paymentItem->cust_status == 0) {
                    $paymentItem->delivery_status  = 'approved';
                }
                $paymentItem->save();
            }
        }
        // Create production task for non-customized products (cust_status = 0)
        if ($paymentItem->cust_status == 0) {
            \App\Models\ProductionTask::create([
                'payment_item_id' => $paymentItem->id,
                'payment_id'      => $payment->id,
                'product_id'      => $paymentItem->product_id,
                'file'            => null, // No custom file for non-customized products
                'status'          => 'pending',
            ]);

            Log::info('Production task created for non-customized product', [
                'payment_item_id' => $paymentItem->id,
                'product_id' => $paymentItem->product_id,
                'payment_order_id' => $paymentItem->payment_order_id
            ]);
        }


        return redirect()->route('orders')->with('success', 'Order created successfully!');
    }
    public function offgenerateBill($orderId)
    {
        $payment = Payment::with(['items.product', 'items.variant', 'user'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        // Check if bill is GST (1) or non-GST (0)
        $isGst = $payment->bill == 1;

        if ($isGst) {
            return view('admin.bills.gst-bill', compact('payment'));
        } else {
            return view('admin.bills.non-gst-bill', compact('payment'));
        }
    }

    public function getDesigners()
    {
        try {
            $designers = User::where('role', 2)
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

            return response()->json([
                'designers' => $designers
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in getDesigners', [
                'message' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Server error while fetching designers'], 500);
        }
    }

    public function transferOrder(Request $request, $paymentId)
    {
        try {
            $request->validate([
                'new_designer_id' => 'required|exists:users,id'
            ]);

            $payment = Payment::findOrFail($paymentId);

            // Get all payment items for this order
            $paymentItems = $payment->items;

            // Update designer for all items that have customization requests
            foreach ($paymentItems as $item) {
                if ($item->customizationRequest) {
                    $item->customizationRequest->update([
                        'designer_id' => $request->new_designer_id
                    ]);
                }

                // Also update the payment item's designer if it exists
                if ($item->designer_id) {
                    $item->update([
                        'designer_id' => $request->new_designer_id
                    ]);
                }
            }

            return back()->with('success', 'Order transferred to new designer successfully.');
        } catch (\Exception $e) {
            Log::error('Error in transferOrder', [
                'payment_id' => $paymentId,
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to transfer order. Please try again.');
        }
    }


    public function savePayment(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:cash,card,upi,netbanking',
            'date' => 'required|date',
            'remark' => 'nullable|string',
        ]);

        $payment->paymentDetails()->create([
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'date' => $request->date,
            'remark' => $request->remark,
        ]);

        return response()->json(['success' => true, 'message' => 'Payment saved successfully']);
    }
}
