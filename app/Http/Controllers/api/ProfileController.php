<?php

// app/Http/Controllers/API/ProfileController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
   public function editProfile(Request $request)
{
    // Get the currently authenticated user (without Sanctum, assumes session or token-based)
    $user = User::where('id',$request->user_id)->first(); // or auth()->user();
//    return $user;
    
    // if (!$userId) {
    //     return response()->json([
    //         'success' => false,
    //         'status_code' => 401,
    //         'message' => 'User id not given',
    //     ], 401);
    // }
    
    
    
    

    //Handle profile image
    if ($request->hasFile('profile_img')) {
        $image = $request->file('profile_img');
        $filename = time() . '.' . $image->extension();

        $filepath = base_path('profile_images/'.$user->profile_img);
        if ($user->profile_img && is_file($filepath)) {
            unlink($filepath);
        }

        $image->move('profile_images/', $filename);
        $user->profile_img = $filename;
    }

    // Update user info

    if($request->has('name')) {
    $user->name = $request->name;
    }
    if($request->has('email')) {
    $user->email = $request->email;
    }
    if($request->has('mobile')) {
    $user->mobile = $request->mobile;
    }
    
    $user->save();

        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Profile updated successfully',
            'updated_user' => $user,
            'profile_img' => $user->profile_img 
            ? base_path('profile_images/' . $user->profile_img) 
            : null,
        ], 200);
    } 
    public function getProfile(Request $req)
{
    $user = User::find($req->user_id);

    if($user){
    return response()->json([
        'success' => true,
         'status_code' => 200,
        'data' => [
            'name'        => $user->name,
            'email'       => $user->email,
            'mobile'      => $user->mobile,
              'profile_img' => $user->profile_img
                    ? (filter_var($user->profile_img, FILTER_VALIDATE_URL)
                        ? $user->profile_img
                        : asset('profile_images/' . $user->profile_img))
                    : null
        ]
    ]);
    }else{
          return response()->json([
        'success' => false,
         'status_code' => 404,
         'message'=>'no user found with this details',
        ]);

}
}}


