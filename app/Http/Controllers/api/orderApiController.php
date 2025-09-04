<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\cartItem;
use App\Models\Page;
use App\Models\WishlistItem;
use App\Models\AwardCategory;
use App\Models\CustomizationRequest;
use Illuminate\Support\Facades\Auth;

class orderApiController extends Controller
{
      public function myOrders(Request $request)
    {
        $userId = $request->user_id;
        if (!$userId) {
            return response()->json([
                'success' => false,
                'status_code' => 401,
                'message' => 'User id not given',
            ], 401);
        }

        // Get user's payment history with items
        $payments = Payment::with([
            'paymentItems.product',
            'paymentItems.variant',
            'paymentItems.customizationRequest',
            'paymentItems.customizationRequest.messages'
        ])
            ->where('customer_id', $userId)
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
            'cart_items' => cartItem::where('user_id', $userId)->count(),
            'pages' => Page::all(),
            'wishlist_count' => WishlistItem::where('user_id',$userId)->count(),
        ];
        $customization_request = CustomizationRequest::where('user_id',$userId)->get();
        $customizationRequest = CustomizationRequest::with('designer')
            ->where('user_id',$userId)
            ->first();
                                                        $custom = $customization_request->firstWhere(
                                                            'payment_item_id',
                                                            $payment->id,
                                                        );

                                                        $customization = CustomizationRequest::
                                                            where('payment_item_id', $payment->id)
                                                            ->where('status', 'pending')
                                                            ->first();
                                                        
                                                        $customizationApproved = CustomizationRequest::where('payment_item_id', $payment->id)
                                                            ->where('status', 'approved')
                                                            ->first();
                                                        if (isset($customizationApproved)) {
                                                        } else {
                                                            $customizationApproved = null;
                                                        }
                                                
       
                          return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'User orders retrieved successfully',
            'orders' => $payments,
            'customization_request' => $customization_request,
            'customizationRequest' => $customizationRequest,
            'commonData' => $commonData,
        ], 200);
    }   
}
