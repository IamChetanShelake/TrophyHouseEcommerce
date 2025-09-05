<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use App\Models\AwardCategory;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\CustomizationMessage;
use App\Models\CustomizationRequest;
use App\Models\Customization_image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PaymentItem;
use App\Models\Payment;
use App\Models\ProductionTask;
use Illuminate\Support\Facades\DB;



class CustomizationController extends Controller
{
    /**
     * Accept a customization request
     */
    public function acceptRequest(Request $request, $orderId)
    {
        
        $designerId = auth()->id();


      DB::transaction(function() use ($orderId, $designerId) {
        // fetch all customization requests linked to this orderId
        $customizations = CustomizationRequest::whereHas('paymentItem.payment', function($q) use ($orderId) {
                $q->where('order_id', $orderId);
            })
            ->get();

        foreach ($customizations as $customization) {
            $customization->update([
                'status' => 'accepted',
                'designer_id' => $designerId,
            ]);
        }

        // Update the delivery_status of the related payment to 'accepted'
         $payment = Payment::where('order_id', $orderId)->first();

         
        if ($payment) {
            $payment->update([
                'delivery_status' => 'accepted'  // delivery_status will now reflect customization status
            ]);
        }


    });

    return redirect()->route('requests');
        // return response()->json(['success' => true, 'message' => 'Request accepted successfully.']);
    }

public function designerChats($customizationRequestId = null)
{
    $designerId = auth()->id();

    // // Get all customization requests assigned to this designer
    // $customizations = CustomizationRequest::with(['cartItem.product', 'paymentItem.product'])
    //     ->where(function($q) use ($designerId) {
    //         $q->where('designer_id', $designerId)
    //           ->orWhere('transferred_from', $designerId);
    //     })
    //     ->get();

    // // Selected customization
    // $activeCustomization = $customizationRequestId ? CustomizationRequest::with(['cartItem.product', 'paymentItem.product', 'messages.sender'])->find($customizationRequestId) : null;

    // $messages = $activeCustomization ? $activeCustomization->messages()->with('sender', 'cartItem.product')->orderBy('created_at')->get() : collect();
      $activeCustomization = CustomizationRequest::with(['messages', 'paymentItem.product', 'cartItem.product'])
        ->findOrFail($customizationRequestId);

    //  Get only customizations from the same order
    $orderId = $activeCustomization->paymentItem?->payment?->order_id;

    $customizations = CustomizationRequest::whereHas('paymentItem.payment', function($q) use ($orderId) {
            $q->where('order_id', $orderId);
        })
        ->with(['paymentItem.product', 'cartItem.product'])
        ->get();

    $messages = $activeCustomization->messages()->with('sender')->get();

    return view('admin.designer.chat', compact('customizations', 'activeCustomization', 'messages','orderId'));
}



    /**
     * Reject a customization request
     */
    // public function rejectRequest(Request $request, $id)
    // {

    //     $customization = CustomizationRequest::findOrFail($id);

    //     if ($customization->status != 'pending') {
    //         //   return redirect()->route('requests')with('error','');
    //         return response()->json(['success' => false, 'message' => 'Request cannot be rejected.'], 403);
    //     }

    //     $customization->status = 'rejected';
    //     $customization->save();


    //     // return response()->json(['success' => true, 'message' => 'Request rejected.']);
    //      return redirect()->route('requests')->with('success','request rejected');
    // }
    public function rejectRequest(Request $request, $orderId)
{
    $designerId = auth()->id();

    DB::transaction(function() use ($orderId, $designerId) {
        // fetch all customization requests linked to this orderId
        $customizations = CustomizationRequest::whereHas('paymentItem.payment', function($q) use ($orderId) {
                $q->where('order_id', $orderId);
            })
            ->get();

        foreach ($customizations as $customization) {
            if ($customization->status == 'pending') {
                $customization->update([
                    'status' => 'rejected',
                    'designer_id' => $designerId,
                ]);
            }
        }
    });

    return redirect()->route('requests')->with('success', 'Request rejected successfully.');
}


    /**
     * Display the workspace for an accepted request
     */
public function orderWorkspace($orderId)
{
    $designerId = auth()->id();

    // Fetch all customization requests under this order
    $requests = CustomizationRequest::with([
        'user',
        'cartItem.product',
        'paymentItem.variant',
        'messages.sender'
    ])
    ->whereHas('paymentItem.payment', function($q) use ($orderId) {
        $q->where('order_id', $orderId)
          ->where('status', 'paid');
    })
    ->where(function ($query) use ($designerId) {
        $query->where(function ($sub) {
            $sub->where('status', 'pending')->whereNull('designer_id');
        })->orWhere(function ($sub) use ($designerId) {
            $sub->where('status', 'accepted')->where('designer_id', $designerId);
        });
    })
    ->get();

    if ($requests->isEmpty()) {
        abort(404, 'No customization requests found for this order.');
    }

    return view('admin.designer.order_workspace', compact('requests', 'orderId'));
}


    public function workspace($id)
    {
        $customization = CustomizationRequest::with('cartItem.product')->findOrFail($id);
        
        $custImg = Customization_image::where('customization_request_id',$customization->id)->get();
      
    
        if (!in_array($customization->status, ['accepted', 'pending','approved']) || $customization->designer_id !== Auth::id()) {
            // abort(403, 'Unauthorized access to this workspace.');
            return redirect()->route('requests');
        }


        return view('designer.workspace', compact('customization','custImg'));
    }

public function approveImage(CustomizationMessage $message)
{
    
    $user = auth()->user();
    

    // Ensure the user owns this customization request
    if ($message->customizationRequest->user_id !== $user->id) {
        abort(403);
    }

    $request = $message->customizationRequest;

    // 🔑 Unapprove all other messages of this request
    $request->messages()
        ->where('id', '!=', $message->id)
        ->update(['is_approved' => 0]);

    // Approve the selected one
    $message->is_approved = 1;
    $message->save();

    // --- Keep your existing request & order update logic ---
    $allApproved = $request->messages()->where('is_approved', 0)->count() === 0;
    if ($allApproved && $request->status !== 'approved') {
        $request->status = 'approved';
        $request->save();
    }

    $payment = $request->paymentItem->payment;
    $allRequestsApproved = $payment->paymentItems->every(function ($item) {
        return $item->customizationRequest && $item->customizationRequest->status === 'approved';
    });

    if ($allRequestsApproved && $payment->delivery_status !== 'approved') {
        $payment->delivery_status = 'approved';
        $payment->save();
    }


    // 4. Create a production task for this approved image
     ProductionTask::create([
        'payment_item_id' => $request->paymentItem->id,
        'payment_id'      => $payment->id,
        'product_id'      => $request->paymentItem->product_id,
        'file'        => $message->attachment, // assuming approved file path is stored here
        'status'          => 'pending',
    ]);

    // return response()->json([
    //     'success' => true,
    //     'message' => 'Image approved successfully',
    // ]);
    return redirect()->back();
}

public function cancelApproval(CustomizationMessage $message)
{
    $user = auth()->user();
    if ($message->customizationRequest->user_id !== $user->id) abort(403);

    $message->is_approved = 0;
    $message->save();

    $request = $message->customizationRequest;

    // If no other images are approved → rollback request status
    if ($request->messages()->where('is_approved', 1)->count() === 0) {
        $request->status = 'accepted'; 
        $request->save();
    }

    return response()->json(['success' => true]);
}


//old approve and cancel approve
//     public function approveImage(CustomizationMessage $message)
// {
//     $user = auth()->user();

//     // Ensure the user owns this customization request
//     if ($message->customizationRequest->user_id !== $user->id) {
//         abort(403);
//     }

//     $message->is_approved = 1;
//     $message->save();

    
//     $request = $message->customizationRequest;

//     // 2. If all messages for this request are approved → mark request as "approved"
//     $allApproved = $request->messages()->where('is_approved', 0)->count() === 0;
//     if ($allApproved && $request->status !== 'approved') {
//         $request->status = 'approved';
//         $request->save();
//     }

//     // 3. If all requests under this order are approved → mark the order as "approved"
//     $payment = $request->paymentItem->payment;
//     $allRequestsApproved = $payment->paymentItems->every(function ($item) {
//         return $item->customizationRequest && $item->customizationRequest->status === 'approved';
//     });

//     if ($allRequestsApproved && $payment->order_status !== 'approved') {
//         $payment->order_status = 'approved';
//         $payment->save();
//     }

//     if ($allApprovedForOrder) {
//         Payment::where('order_id', $orderId)->update([
//             'order_status' => 'approved'
//         ]);
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'Image approved successfully',
//     ]);
// }

// //cancel approve 
// public function cancelApproval(CustomizationMessage $message)
// {
//     $user = auth()->user();
//     if ($message->customizationRequest->user_id !== $user->id) abort(403);

//     $message->is_approved = 0;
   
//     $message->save();

//     return response()->json(['success' => true]);
// }

public function finalize($paymentId)
{
    $payment = Payment::with('items.customizationRequest.messages')
    ->where('order_id', $paymentId)
    ->firstOrFail();
    // return auth()->id();

    // Ensure payment belongs to the logged-in user
    if ($payment->customer_id != auth()->id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Check if there is at least one approved message across all customizations
    $hasApproved = false;
    foreach ($payment->items as $item) {
        if ($item->customizationRequest && $item->customizationRequest->messages()->where('is_approved', 1)->exists()) {
            $hasApproved = true;
            break;
        }
    }

    if (!$hasApproved) {
        return redirect()->back()->with('error', 'You must approve at least one image before finalizing.');
    }

    // Finalize all related customization requests
    foreach ($payment->items as $item) {
        if ($item->customizationRequest) {
            $item->customizationRequest->update([
                'status' => 'approved',
            ]);
        }
    }

    return redirect()->back()->with('success', 'Customization finalized successfully for the entire order!');
}


// public function finalize($id)
// {
//     $customization = CustomizationRequest::findOrFail($id);

//     // Check if the customization belongs to the logged-in user
//     if ($customization->user_id !== auth()->id()) {
//         return redirect()->back()->with('error', 'Unauthorized action.');
//     }

//     // Check if at least one message is approved
//     $approvedMessageCount = $customization->messages()->where('is_approved', 1)->count();
//     if ($approvedMessageCount == 0) {
//         return redirect()->back()->with('error', 'You must approve at least one image before finalizing.');
//     }

//     // Finalize the customization
//     $customization->status = 'finalized';
//     $customization->finalized_at = now();
//     $customization->save();

//     return redirect()->back()->with('success', 'Customization finalized successfully!');
// }





    public function completeRequest(Request $request, $id)
    {
        $customization = CustomizationRequest::findOrFail($id);

        if ($customization->status !== 'accepted' || $customization->designer_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            
            'final_image' => 'required',
        ]);
        
    // return $request->file('final_image');
    // return $request->final_image->extension();
         $imageName = time() . '.' .$request->final_image->extension();
       
         
            $request->final_image->move('customizations',$imageName);
            $custMsg = new CustomizationMessage();
            
            $custMsg->customization_request_id = $customization->id;
            $custMsg->sender_id = $customization->user_id;
            $custMsg->message = $request->message;
            $custMsg->attachment = $imageName;
            $custMsg->save();
           

        // $customization->final_image = $finalImagePath;

        // Change this:
        $customization->status = 'pending';

        $customization->save();
        
        // Notify the user
        // $customization->user->notify(new \App\Notifications\CustomizationCompleted($customization));
        // dd('crct');

        return redirect()->route('dashboard')->with('success', 'Design submitted. Waiting for user approval.');
    }
    
    public function transferRequest(Request $request, $orderId)
{
    $request->validate([
        'new_designer_id' => 'required|exists:users,id',
    ]);

    // Get all customization requests under this order that are accepted
    $customizations = CustomizationRequest::where('payment_item_id', function($q) use ($orderId) {
        $q->select('id')
          ->from('payment_items')
          ->where('order_id', $orderId);
    })->where('status', 'accepted')->get();

    // Only the current designer can transfer
    
    if ($customization->designer_id !== auth()->id()) {
        return back()->with('error', 'Unauthorized');
    }

    $customization->transferred_from = $customization->designer_id;
    $customization->designer_id = $request->new_designer_id;
    $customization->status = 'accepted'; // remains accepted
    $customization->save();

    return back()->with('success', 'Request transferred successfully.');
}


    public function approveRequest(Request $request, $id)
    {
        $customization = CustomizationRequest::findOrFail($id);
        if ($customization->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action or invalid status.');
        }

        $customization->status = 'approved';
        $customization->save();

        return redirect()->route('cartPage')->with('success', 'Customization approved successfully.');
    }

    // public function requestEdit(Request $request, $id)
    // {
    //     $customization = CustomizationRequest::findOrFail($id);

    //     if ($customization->user_id !== Auth::id() || $customization->status !== 'completed') {
    //         return redirect()->back()->with('error', 'Unauthorized action or invalid status.');
    //     }

    //     $request->validate([
    //         'user_feedback' => 'required|string',
    //     ]);

    //     $customization->user_feedback = $request->user_feedback;
    //     $customization->status = 'pending_edits';
    //     $customization->save();

    //     // Notify the designer
    //     $customization->designer->notify(new \App\Notifications\EditRequested($customization));

    //     return redirect()->route('cartPage')->with('success', 'Edit request sent to designer.');
    // }
    public function requestEdit(Request $request, $id)
    {
        $customization = CustomizationRequest::findOrFail($id);

        if ($customization->user_id !== Auth::id() || $customization->status !== 'completed') {
            return redirect()->back()->with('error', 'Unauthorized action or invalid status.');
        }

        $request->validate([
            'user_feedback' => 'required|string',
        ]);

        $customization->user_feedback = $request->user_feedback;
        $customization->status = 'pending';
        $customization->save();

        // ✅ Notify only if a designer is assigned
        if ($customization->designer) {
            $customization->designer->notify(new \App\Notifications\EditRequested($customization));
        }

        return redirect()->route('cartPage')->with('success', 'Edit request sent to designer.');
    }

    public function approvedRequest(Request $request, $id)
    {
        $customization = CustomizationRequest::findOrFail($id);

        if ($customization->user_id !== Auth::id() || !in_array($customization->status, ['pending', 'accepted'])) {
            return redirect()->back()->with('error', 'Unauthorized action or invalid status.');
        }

        // $customization->status = 'completed';
        $customization->save();

        return redirect()->route('cartPage')->with('success', 'Customization approved successfully.');
    }
    // public function sendMessage(Request $request, $id)
    // {
    //     $request->validate([
    //         'message' => 'nullable|string',
    //         'attachment' => 'nullable|file|max:2048',
    //     ]);

    //     $customization = CustomizationRequest::findOrFail($id);

    //     $attachmentPath = null;
    //     if ($request->hasFile('attachment')) {
    //         $attachmentPath = $request->file('attachment')->store('messages', 'public');
    //     }

    //     \App\Models\CustomizationMessage::create([
    //         'customization_request_id' => $customization->id,
    //         'sender_id' => Auth::id(),
    //         'message' => $request->message,
    //         'attachment' => $attachmentPath,
    //         'sent_at' => now(),
    //     ]);

    //     return redirect()->back()->with('success', 'Message sent.');
    // }
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string',
            'attachment' => 'nullable',
        ]);

        $customization = CustomizationRequest::find($id);
       
        // Determine sender based on guard
        // if (Auth::guard('designer')->check()) {
        //     $senderId = Auth::guard('designer')->id();
        // } elseif (Auth::check()) {
        //     $senderId = Auth::id();
        // } else {
        //     abort(403, 'Unauthorized');
        // }
        $senderId = Auth::id();

         $activeDesignerId = $customization->transferred_to ?? $customization->designer_id;

        // $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            // $attachmentPath = $request->file('attachment')->store('messages', 'public');
              $imageName = time() . '.' .$request->file('attachment')->extension();
              $request->file('attachment')->move('customizations',$imageName);
        }

        CustomizationMessage::create([
            'customization_request_id' => $customization->id,
            'cart_item_id'=>$customization->cart_item_id,
            'sender_id' => $senderId,
            'receiver_id' =>$activeDesignerId,
            'message' => $request->message,
            'attachment' => $imageName ?? null,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
    
    public function sendDesignerMessage(Request $request, $userId)
{
    $request->validate([
        'message' => 'nullable|string',
        'attachment' => 'nullable',
    ]);

    // Find customization where the current designer is assigned & talking to this user
    
    // $customization = CustomizationRequest::where('designer_id', Auth::id())
    //     ->where('user_id', $userId)
    //     ->first();
    $customization = CustomizationRequest::where(function ($query) {
        $query->where('designer_id', Auth::id())
              ->orWhere('transferred_from', Auth::id());
    })
    ->where('user_id', $userId)
    ->first();
    // dd($customization);

    $senderId = Auth::id(); // designer
    $receiverId = $userId;  // user

    $imageName = null;
       
    if ($request->hasFile('attachment')) {
        $imageName = time() . '.' . $request->File('attachment')->extension();
        $request->File('attachment')->move('customizations', $imageName);
       
    }
       

    CustomizationMessage::create([
        'customization_request_id' => $customization->id,
        'cart_item_id'=>$customization->cart_item_id,
        'sender_id' => $senderId,
        'receiver_id' => $receiverId,
        'message' => $request->message,
        'attachment' => $imageName ?? null,
        'sent_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Message sent to user.');
}
    
   public function showRequests()
{
    $designerId = auth()->id();


// Get all order IDs where requests are already accepted by other designers
$blockedOrderIds = CustomizationRequest::where('status', 'accepted')
    ->whereNotNull('designer_id')
    ->where('designer_id', '!=', $designerId)
    ->pluck('payment_item_id') // temporarily get payment_item_id
    ->map(function($paymentItemId) {
        $paymentItem = PaymentItem::find($paymentItemId);
        return $paymentItem ? $paymentItem->payment->order_id : null;
    })
    ->filter()
    ->unique()
    ->toArray();

// Now fetch requests visible to current designer
$requests = CustomizationRequest::with([
        'user',
        'paymentItem.product',
        'paymentItem.variant',
        'paymentItem.payment.paymentItems.product',
        'paymentItem.payment.paymentItems.variant',
    ])
    ->whereHas('paymentItem.payment', function ($q) {
        $q->where('status', 'paid');
    })
    ->where(function ($query) use ($designerId) {
        $query->where(function ($sub) {
            $sub->where('status', 'pending')->whereNull('designer_id');
        })->orWhere(function ($sub) use ($designerId) {
            $sub->where('status', 'accepted')->where('designer_id', $designerId);    
        })->orWhere(function ($sub) use ($designerId) {
            $sub->where('status', 'approved     ')->where('designer_id', $designerId);    
        })->orWhere(function ($sub) use ($designerId) {
        $sub->where('status', 'completed')->where('designer_id', $designerId);
        })->orWhere(function ($sub) use ($designerId) {
        $sub->where('status', 'rejected')->where('designer_id','!=', $designerId);
    });
    })
    ->get()
    ->filter(function ($request) use ($designerId, $blockedOrderIds) {
        return $request->paymentItem && $request->paymentItem->payment
            && !in_array($request->paymentItem->payment->order_id, $blockedOrderIds)
            && $request->status !== 'rejected' || $request->designer_id !== $designerId; 
    })
    ->groupBy(function($request) {
        return $request->paymentItem->payment->order_id;
    });
    
   

    // Other designers for transfer dropdown
    $otherDesigners = User::where('role', 2) // role = 2 for designers
        ->where('id', '!=', $designerId) // exclude current designer
        ->get();

    return view('admin.designer.requests', compact('requests', 'otherDesigners'));
}


public function showRecustomizations()
{
    $recustoms = CustomizationRequest::where('status', 'pending_edits')
        ->where('designer_id', Auth::id())
        ->get();

    return view('admin.designer.recustomizations', compact('recustoms'));
}

public function chatThreads()
{
    $threads = CustomizationRequest::with(['user', 'messages' => function ($q) {
        $q->latest();
    }])
    ->where('designer_id', Auth::id())
    ->get();

    return view('admin.designer.chats', compact('threads', 'activeUser', 'messages'));
}

    public function userChat($id)
    {
        $user = auth()->user();
        $customization = CustomizationRequest::where('id', $id ?? null)
            ->where('user_id', $user->id)
            ->with(['messages.sender',  'messages.cartItem.product', 'designer'])
            ->firstOrFail();

        
        // 👇 Add this line to fix the error
        $categories = AwardCategory::all();
        $cart_items = 0; // or fetch actual count from Cart model or session if available
        $pages = Page::all();

        return view('website.customizationChat', compact('customization', 'categories', 'cart_items', 'pages'));
    }

    public function sendUserMessage(Request $request, $id)
    {
        
        $request->validate([
            'message' => 'nullable|string',
            'attachment' => 'nullable',
        ]);

        $customization = Customization::findOrFail($id);

        if (auth()->id() !== $customization->user_id) {
            abort(403);
        }

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->move('attachments');
        }

        $customization->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'attachment' => $path ?? null,
            'sent_at' => now(),

        ]);

        return back()->with('success', 'Message sent successfully.');
    }
}
