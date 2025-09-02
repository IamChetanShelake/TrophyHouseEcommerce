<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\AwardCategory;
use App\Models\cartItem;
use App\Models\Page;
use App\Models\WishlistItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Address;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\CustomizationRequest;
use App\Models\CustomizationMessage;
use App\Models\Customization_image;
use App\Models\User;


class PaymentController extends Controller
{
    private function getBaseUrl()
    {
        if (config('services.cashfree.stage') == 'SANDBOX') {
            return 'https://sandbox.cashfree.com/pg';
        } else {
            return 'https://api.cashfree.com/pg';
        }
    }

    private function getCommonViewData()
    {
        return [
            'categories' => AwardCategory::with('products')->get(),
            'cart_items' => Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0,
            'pages' => Page::all(),
            'wishlist_count' => Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0,
        ];
    }

    public function createOrder(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'amount' => 'required|numeric|min:1',
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please login to proceed with payment.');
            }

            $user = Auth::user();
            $orderId = 'TH_' . time() . '_' . $user->id;
            // $amount = $request->input('amount');
            $amount = round($request->input('amount'), 2);


            // Prepare customer details
            $customerDetails = [
                'customer_id' => (string)$user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '9999999999',
            ];

            Log::info('Creating Cashfree Order:', [
                'order_id' => $orderId,
                'amount' => $amount,
                'customer_details' => $customerDetails,
            ]);

            // Prepare order data
            $orderData = [
                'order_id' => $orderId,
                'order_amount' => (float)$amount,
                'order_currency' => 'INR',
                'customer_details' => $customerDetails,
                'order_meta' => [
                    'return_url' => url('/payment-callback?order_id=' . $orderId),
                    'notify_url' => url('/payment-webhook'),
                ],
                'order_note' => 'Trophy House Order Payment',
            ];

            // Make API call to Cashfree
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-client-id' => config('services.cashfree.app_id'),
                'x-client-secret' => config('services.cashfree.secret_key'),
                'x-api-version' => '2023-08-01',
                'x-request-id' => uniqid(),
            ])->post($this->getBaseUrl() . '/orders', $orderData);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('Cashfree Order Created Successfully:', $result);

                // Store payment record in database
                DB::table('payments')->insert([
                    'order_id' => $orderId,
                    'cf_order_id' => $result['cf_order_id'],
                    'amount' => $amount,
                    'currency' => 'INR',
                    'customer_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? '9999999999',
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Return checkout view with payment session ID
                return view('payments.checkout', [
                    'payment_session_id' => $result['payment_session_id'],
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'stage' => config('services.cashfree.stage')
                ]);
            } else {
                Log::error('Cashfree Order Creation Failed:', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                
                return redirect()->back()->with('error', 'Payment initialization failed. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Payment Creation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again.');
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            $orderId = $request->query('order_id');
            
            if (!$orderId) {
                Log::error('Payment callback received without order_id');
                return view('payments.failed', array_merge($this->getCommonViewData(), ['message' => 'Invalid payment callback']));
            }

            Log::info('Payment Callback Received:', ['order_id' => $orderId]);

            // Get order details from Cashfree
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-client-id' => config('services.cashfree.app_id'),
                'x-client-secret' => config('services.cashfree.secret_key'),
                'x-api-version' => '2023-08-01',
            ])->get($this->getBaseUrl() . '/orders/' . $orderId);

            if ($response->successful()) {
                $orderResult = $response->json();
                Log::info('Order Status Retrieved:', $orderResult);

                if ($orderResult['order_status'] == 'PAID') {
                    // Get payment details
                    $paymentsResponse = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'x-client-id' => config('services.cashfree.app_id'),
                        'x-client-secret' => config('services.cashfree.secret_key'),
                        'x-api-version' => '2023-08-01',
                    ])->get($this->getBaseUrl() . '/orders/' . $orderId . '/payments');

                    if ($paymentsResponse->successful()) {
                        $payments = $paymentsResponse->json();
                        $successfulPayment = null;

                        // Find successful payment
                        foreach ($payments as $payment) {
                            if ($payment['payment_status'] == 'SUCCESS') {
                                $successfulPayment = $payment;
                                break;
                            }
                        }

                        if ($successfulPayment) {
                            // Update payment status in database
                            DB::table('payments')
                                ->where('order_id', $orderId)
                                ->update([
                                    'status' => 'paid',
                                    'payment_mode' => $successfulPayment['payment_group'] ?? 'unknown',
                                    'transaction_id' => $successfulPayment['cf_payment_id'],
                                    'updated_at' => now(),
                                ]);

                            Log::info('Payment marked as successful:', ['order_id' => $orderId]);
                            
                            // Store payment items before clearing cart
                            $this->storePaymentItems($orderId);
                            
                            // Create order from cart items before clearing cart
                            $this->createOrderFromCart($orderId, $orderResult['order_amount'], $successfulPayment['payment_group'] ?? 'unknown');
                            
                            // Clear cart after successful payment
                            $this->clearUserCart();
                            
                            return view('payments.success', array_merge($this->getCommonViewData(), [
                                'payment' => $orderResult,
                                'transaction_id' => $successfulPayment['cf_payment_id'],
                                'order_id' => $orderId
                            ]));
                        }
                    }
                }

                // Payment failed or not successful
                DB::table('payments')
                    ->where('order_id', $orderId)
                    ->update([
                        'status' => 'failed',
                        'updated_at' => now(),
                    ]);

                Log::info('Payment marked as failed:', ['order_id' => $orderId]);
                return view('payments.failed', array_merge($this->getCommonViewData(), ['order_id' => $orderId]));

            } else {
                Log::error('Failed to retrieve order status:', [
                    'order_id' => $orderId,
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                
                return view('payments.failed', array_merge($this->getCommonViewData(), ['message' => 'Unable to verify payment status']));
            }
        } catch (\Exception $e) {
            Log::error('Payment Callback Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('payments.failed', array_merge($this->getCommonViewData(), ['message' => 'An error occurred while processing payment callback']));
        }
    }

    public function paymentWebhook(Request $request)
    {
        try {
            Log::info('Payment Webhook Received:', $request->all());

            // Verify webhook signature if webhook secret is configured
            if (config('services.cashfree.webhook_secret')) {
                $signature = $request->header('x-webhook-signature');
                $timestamp = $request->header('x-webhook-timestamp');
                $rawBody = $request->getContent();
                
                // Verify signature logic here if needed
                // This is optional but recommended for production
            }

            $data = $request->all();
            
            if (isset($data['type']) && $data['type'] === 'PAYMENT_SUCCESS_WEBHOOK') {
                $orderId = $data['data']['order']['order_id'];
                $paymentDetails = $data['data']['payment'];

                // Update payment status
                DB::table('payments')
                    ->where('order_id', $orderId)
                    ->update([
                        'status' => 'paid',
                        'payment_mode' => $paymentDetails['payment_group'] ?? 'unknown',
                        'transaction_id' => $paymentDetails['cf_payment_id'],
                        'updated_at' => now(),
                    ]);

                Log::info('Payment updated via webhook:', ['order_id' => $orderId]);
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('Webhook Processing Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['status' => 'error'], 500);
        }
    }

    private function createOrderFromCart($paymentOrderId, $totalAmount, $paymentMethod)
    {
        try {
            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();
            
            // Get user's cart items
            $cartItems = cartItem::with(['product', 'variant'])
                ->where('user_id', $user->id)
                ->get();

            if ($cartItems->isEmpty()) {
                Log::warning('No cart items found for user during order creation', ['user_id' => $user->id]);
                return;
            }

            // Get the payment record
            $payment = Payment::where('order_id', $paymentOrderId)->first();
            if (!$payment) {
                Log::error('Payment record not found for order creation', ['payment_order_id' => $paymentOrderId]);
                return;
            }

            // Calculate total price from cart items
            $calculatedTotal = 0;
            foreach ($cartItems as $cartItem) {
                $variant = $cartItem->variant;
                $unitPrice = $variant ? ($variant->discounted_price ?? $variant->price) : 0;
                $calculatedTotal += $unitPrice * $cartItem->quantity;
            }

            // Create single order record for all products
            $order = new Order();
            $order->payment_id = $payment->id;
            $order->user_id = $user->id;
            $order->total_price = $calculatedTotal;
            $order->status = 'approved';
            $order->save();

            Log::info('Order created successfully', [
                'order_id' => $order->order_id,
                'payment_order_id' => $paymentOrderId,
                'payment_id' => $payment->id,
                'user_id' => $user->id,
                'total_price' => $calculatedTotal
            ]);

            // Create order_products records for each cart item
            foreach ($cartItems as $cartItem) {
                $variant = $cartItem->variant;
                
                if (!$variant) {
                    Log::warning('Variant not found for cart item', [
                        'cart_item_id' => $cartItem->id,
                        'product_id' => $cartItem->product_id
                    ]);
                    continue;
                }

                $unitPrice = $variant->discounted_price ?? $variant->price;

                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->order_id;
                $orderProduct->payment_id = $payment->id;
                $orderProduct->variant_id = $cartItem->variant_id;
                $orderProduct->unit_price = $unitPrice;
                $orderProduct->quantity = $cartItem->quantity;
                $orderProduct->status = 'approved';
                $orderProduct->save();

                Log::info('Order product created successfully', [
                    'order_product_id' => $orderProduct->id,
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->id,
                    'variant_id' => $cartItem->variant_id,
                    'unit_price' => $unitPrice,
                    'quantity' => $cartItem->quantity
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error creating order from cart:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'payment_order_id' => $paymentOrderId
            ]);
        }
    }

    private function storePaymentItems($paymentOrderId)
    {
        try {
            if (!Auth::check()) {
                 Log::warning('storePaymentItems called without authenticated user');
                return;
            }

            $user = Auth::user();
            $payment = Payment::where('order_id', $paymentOrderId)->first();
             if (!$payment) {
            Log::error('Payment record not found while storing payment items', [
                'payment_order_id' => $paymentOrderId,
                'user_id' => $user->id
            ]);
            return;
        }
            // Get user's cart items
            $cartItems = cartItem::with(['product', 'variant'])
                ->where('user_id', $user->id)
                ->get();

            if ($cartItems->isEmpty()) {
                Log::warning('No cart items found for payment items storage', ['user_id' => $user->id]);
                return;
            }

            // Store each cart item as a payment item
            foreach ($cartItems as $cartItem) {
                $variant = $cartItem->variant;
                $unitPrice = $variant ? ($variant->discounted_price ?? $variant->price) : 0;
                $totalPrice = $unitPrice * $cartItem->quantity;

                $paymentItem = PaymentItem::create([
                    'payment_order_id' => $paymentOrderId,
                    'payment_id' => $payment->id,
                    'user_id' => $user->id,
                    'product_id' => $cartItem->product_id,
                    'variant_id' => $cartItem->variant_id,
                    'color' => $cartItem->color,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice
                ]);

               Log::info('Payment item stored successfully', [
                'payment_item_id' => $paymentItem->id,
                'payment_order_id' => $paymentOrderId,
                'product_id' => $cartItem->product_id,
                'variant_id' => $cartItem->variant_id,
                 'color' => $cartItem->color,
                'quantity' => $cartItem->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice
            ]);

                // Link customization requests to this payment item
            CustomizationRequest::where('cart_item_id', $cartItem->id)
                ->update([
                    'payment_item_id' => $paymentItem->id,
                    'cart_item_id'    => null // unlink to avoid cascade delete
                ]);
            }

             // After processing all items, delete the cart
        cartItem::where('user_id', $user->id)->delete();
        Log::info('Cart items deleted after storing payment items', ['user_id' => $user->id]);

        } catch (\Exception $e) {
            Log::error('Error storing payment items:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'payment_order_id' => $paymentOrderId
            ]);
        }
    }

    private function clearUserCart()
    {
        try {
            if (Auth::check()) {

                $userId = Auth::id();

            // Just in case any cart_item_id is still linked in customization_requests, unlink it
           CustomizationRequest::where('user_id', $userId)
                ->update(['cart_item_id' => null]);

                DB::table('cart_items')->where('user_id', Auth::id())->delete();

                Log::info('Cart cleared for user:', ['user_id' => Auth::id()]);
            }
        } catch (\Exception $e) {
            Log::error('Error clearing cart:', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
        }
    }
}
