<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomizationRequest;
use App\Models\Customization_image;


class customizationApiController extends Controller
{
     // Store new customization
    public function store(Request $request)
    {


      $customization = new CustomizationRequest();
        
        $customization->user_id = $request->user_id;
        
        $customization->cart_item_id = $request->product_id;
        
        $customization->designer_id = null;
        
        $customization->description = $request->content;
        
        $customization->status = 'pending';
        
        
        $customization->save();
        // Loop through images and store each
        
        foreach ($request->file('images') as $image) {
            
            $imageName = time() . rand(1, 1000) . '.' . $image->extension();
            
            // Move the file to the public directory
            $image->move('customization_images', $imageName);
            
            // Store each image using model instance
            $customization_image = new Customization_image();
            
            $customization_image->user_id = $request->user_id;
            
            $customization_image->customization_request_id = $customization->id;
            
            $customization_image->image = $imageName;
            
            $customization_image->save();
            
        }
        
        // return response()->json(['success' => true, 'message' => 'Request sent to designers']);
        return redirect()->back()->with('success', 'Your Customization Request has been sent, please wait for our  response');

        return response()->json([
            'status'=>true,
            'status_code'=>200,
            'message' => ' Your Customization is Submitted, our Team will contact you soon!',
            'data'    => $customization
        ], 200);
    }

    // List all customizations for a user
    public function index($userId)
    {
        $customizations = CustomizationRequest::with('product')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $customizations
        ]);
    }

    // Show single customization
    public function show($id)
    {
        $customization = CustomizationRequest::with('product')->find($id);

        if (!$customization) {
            return response()->json([
                'success' => false,
                'message' => 'Customization not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $customization
        ]);
    }

    // Update status (admin use)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,approved'
        ]);

        $customization = CustomizationRequest::find($id);

        if (!$customization) {
            return response()->json([
                'success' => false,
                'message' => 'Customization not found'
            ], 404);
        }

        $customization->status = $request->status;
        $customization->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data'    => $customization
        ]);
    }
}
