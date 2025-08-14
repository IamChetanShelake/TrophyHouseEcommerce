<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressApiController extends Controller
{
    // List all addresses of the authenticated user
    // public function index()
    // {
    //      $user = auth()->user();
     
    //     $addresses = Address::where('user_id', auth()->user()->id)->get();

    //     return response()->json([
    //         'success' => true,
    //         'addresses' => $addresses
    //     ]);
    // }
    
    public function index(Request $request)
{
    $userId = $request->input('user_id'); // Request se le rahe

    if (!$userId) {
        return response()->json([
            'success' => false,
            'status_code' => 400,
            'message' => 'User ID is required'
        ], 400);
    }

    $addresses = Address::where('user_id', $userId)->get();

    return response()->json([
        'success' => true,
        'status_code' => 200,
        'addresses' => $addresses
    ]);
}

    // Store new address
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name'      => 'required|string',
    //         'phone'     => 'required|string',
    //         'email'     => 'required|email',
    //         'pincode'   => 'required|string',
    //         'address'   => 'required|string',
    //         'city'      => 'required|string',
    //         'state'     => 'required|string',
    //         'country'   => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $address = Address::create([
    //         'user_id'   => $request->user()->id,
    //         'name'      => $request->name,
    //         'phone'     => $request->phone,
    //         'email'     => $request->email,
    //         'pincode'   => $request->pincode,
    //         'address'   => $request->address,
    //         'city'      => $request->city,
    //         'state'     => $request->state,
    //         'country'   => $request->country,
    //         'delivery_instructions' => $request->delivery_instructions,
    //         'is_default' => $request->is_default ?? false,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Address added successfully',
    //         'address' => $address
    //     ]);
    // }
    public function store(Request $request)
{
    $userId = $request->input('user_id'); // Request se le rahe

    if (!$userId) {
        return response()->json([
            'success' => false,
            'status_code' => 400,
            'message' => 'User ID is required'
        ], 400);
    }

    $validator = Validator::make($request->all(), [
        'name'      => 'required|string',
        'phone'     => 'required|string',
        'email'     => 'required|email',
        'pincode'   => 'required|string',
        'address'   => 'required|string',
        'city'      => 'required|string',
        'state'     => 'required|string',
        'country'   => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $address = Address::create([
        'user_id'   => $userId,
        'name'      => $request->name,
        'phone'     => $request->phone,
        'email'     => $request->email,
        'pincode'   => $request->pincode,
        'address'   => $request->address,
        'city'      => $request->city,
        'state'     => $request->state,
        'country'   => $request->country,
        'delivery_instructions' => $request->delivery_instructions,
        'is_default' => $request->is_default ?? false,
    ]);

    return response()->json([
        'success' => true,
        'status_code' => 200,
        'message' => 'Address added successfully',
        'address' => $address
    ]);
}

    // how specific address
    // public function show($id)
    // {
    //     $address = Address::find($id);

    //     if (!$address) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Address not found'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'address' => $address
    //     ]);
    // }
    public function show(Request $request)
{
    $userId = $request->input('user_id'); // Request se le rahe
    $address_id = $request->input('address_id'); // Request se le rahe

    if (!$userId) {
        return response()->json([
            'success' => false,
            'status_code' => 400,
            'message' => 'User ID is required'
        ], 400);
    }

    $address = Address::where('id', $address_id)
        ->where('user_id', $userId)
        ->first();

    if (!$address) {
        return response()->json([
            'success' => false,
            'status_code' => 404,
            'message' => 'Address not found for this user'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'status_code' => 200,
        'address' => $address
    ]);
}

    // Update address
    public function update(Request $request)
    {
           $userId = $request->input('user_id'); 
    $address_id = $request->input('address_id'); 
    
    $address = Address::where('id', $address_id)
        ->where('user_id', $userId)
        ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                 'status_code' => 404,
                'message' => 'Address not found'
            ], 404);
        }

        $address->update($request->only([
            'name', 'phone', 'email', 'pincode', 'address', 'city', 'state', 'country', 'delivery_instructions', 'is_default'
        ]));

        return response()->json([
            'success' => true,
             'status_code' => 200,
            'message' => 'Address updated successfully',
            'address' => $address
        ],200);
    }

    // elete address
    public function destroy($id)
    {
        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ]);
    }
}
