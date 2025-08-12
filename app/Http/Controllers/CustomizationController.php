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


class CustomizationController extends Controller
{
    /**
     * Accept a customization request
     */
    public function acceptRequest(Request $request, $id)
    {
        $customization = CustomizationRequest::findOrFail($id);
    
        if ($customization->status != 'pending') {
            return response()->json(['success' => false, 'message' => 'Request cannot be accepted.'], 403);
        }

        $customization->designer_id = Auth::id();
        $customization->status = 'accepted';
        $customization->save();

    return redirect()->route('requests');
        // return response()->json(['success' => true, 'message' => 'Request accepted successfully.']);
    }

    public function designerChats($userId = null)
{
   $designerId = Auth::id();

// Fetch all user IDs that the designer has chatted with
$chatUserIds = CustomizationMessage::where(function ($query) use ($designerId) {
    $query->where('sender_id', $designerId)
          ->orWhere('receiver_id', $designerId);
})
->get()
->flatMap(function ($msg) {
    return [$msg->sender_id, $msg->receiver_id];
})
->filter(function ($id) use ($designerId) {
    return $id != $designerId;
})
->unique();

// Get User models for these IDs
$users = User::whereIn('id', $chatUserIds)->get();
// Get selected chat user and their messages
$activeUser = $userId ? User::find($userId) : null;

// return $a = CustomizationMessage::with('cartItem')->get();
$messages = $activeUser ? CustomizationMessage::where(function ($query) use ($designerId, $userId) {
    $query->where('sender_id', $designerId)->where('receiver_id', $userId);
})->orWhere(function ($query) use ($designerId, $userId) {
    $query->where('sender_id', $userId)->where('receiver_id', $designerId);
})->orderBy('created_at')->get() : collect();

// $messages = CustomizationMessage::with('cartItem.product')->find(84);
// return $messages->cartItem->product->title;

$messages = $activeUser ? CustomizationMessage::with('cartItem.product')->where(function ($query) use ($designerId, $userId) {
    $query->where('sender_id', $designerId)->where('receiver_id', $userId);
})->orWhere(function ($query) use ($designerId, $userId) {
    $query->where('sender_id', $userId)->where('receiver_id', $designerId);
})->orderBy('created_at')->get() : collect();


    return view('admin.designer.chat', compact('users', 'activeUser', 'messages'));
}
    /**
     * Reject a customization request
     */
    public function rejectRequest(Request $request, $id)
    {

        $customization = CustomizationRequest::findOrFail($id);

        if ($customization->status != 'pending') {
            //   return redirect()->route('requests')with('error','');
            return response()->json(['success' => false, 'message' => 'Request cannot be rejected.'], 403);
        }

        $customization->status = 'rejected';
        $customization->save();


        // return response()->json(['success' => true, 'message' => 'Request rejected.']);
         return redirect()->route('requests')->with('success','request rejected');
    }

    /**
     * Display the workspace for an accepted request
     */
    public function workspace($id)
    {
        $customization = CustomizationRequest::with('cartItem.product')->findOrFail($id);
        
        $custImg = Customization_image::where('customization_request_id',$customization->id)->get();
        // return $custImg;
    // foreach($custImg as $img){
    //     echo $img->image;
    // }
    
        if (!in_array($customization->status, ['accepted', 'pending','approved']) || $customization->designer_id !== Auth::id()) {
            // abort(403, 'Unauthorized access to this workspace.');
            return redirect()->route('requests');
        }


        return view('designer.workspace', compact('customization','custImg'));
    }




    /**
     * Mark a customization request as completed with a final image
     */
    //     public function completeRequest(Request $request, $id)
    // {
    //     $customization = CustomizationRequest::findOrFail($id);

    //     if ($customization->status !== 'accepted' || $customization->designer_id !== Auth::id()) {
    //         return redirect()->back()->with('error', 'Unauthorized action.');
    //     }

    //     $request->validate([
    //         'final_image' => 'required|image|max:2048',
    //     ]);

    //     $finalImagePath = $request->file('final_image')->store('customizations', 'public');
    //     $customization->final_image = $finalImagePath;
    //     $customization->status = 'completed';
    //     $customization->save();

    //     // Trigger the notification to the user
    //     $customization->user->notify(new \App\Notifications\CustomizationCompleted($customization));

    //     return redirect()->route('home')->with('success', 'Request completed successfully.');
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
    
    public function transferRequest(Request $request, $id)
{
    $request->validate([
        'new_designer_id' => 'required|exists:users,id',
    ]);

    $customization = CustomizationRequest::findOrFail($id);

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
    // $requests = CustomizationRequest::where(function ($query) {
    //     $query->whereNull('designer_id')->orWhere('designer_id', Auth::id());
    // })->get();
    // Show only relevant requests:
    $designerId = auth()->id();
$requests = CustomizationRequest::with(['user', 'cartItem.product'])->where(function ($query) use ($designerId) {
    $query->where('status', 'pending')
          ->whereNull('designer_id');
})->orWhere(function ($query) use ($designerId) {
    $query->where('status', 'accepted')
          ->where('designer_id', $designerId);
})->get();

$otherDesigners = User::where('role', 2)  // or role = 2 if using integer roles
    ->where('id', '!=', Auth::id()) // exclude current designer
    ->get();

    return view('admin.designer.requests', compact('requests','otherDesigners'));
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
        $customization = CustomizationRequest::where('id', $id)
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
