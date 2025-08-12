<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressApiController extends Controller
{
    // ✅ List all addresses of the authenticated user
    public function index()
    {
         $user = auth()->user();
     
        $addresses = Address::where('user_id', auth()->user()->id)->get();

        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    // ✅ Store new address
    public function store(Request $request)
    {
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
            'user_id'   => $request->user()->id,
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
            'message' => 'Address added successfully',
            'address' => $address
        ]);
    }

    // ✅ Show specific address
    public function show($id)
    {
        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    // ✅ Update address
    public function update(Request $request, $id)
    {
        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->update($request->only([
            'name', 'phone', 'email', 'pincode', 'address', 'city', 'state', 'country', 'delivery_instructions', 'is_default'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully',
            'address' => $address
        ]);
    }

    // ✅ Delete address
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
