<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
        public function signup(Request $req){
          
           
    $userFound = User::where('email',$req->email)->orWhere('mobile',$req->phone)->exists();
   
    //  return response()->json([
    //         'status' => true,
    //         'status_code' => '200',
    //         'userfoundvariable' => $userFound,
    //     ], 200);
    if($userFound){
          return response()->json([
            'status' => false,
            'status_code' => '400',
            'message' => 'A user Already Exists with that email or phone number',
        ], 400);
    }else{
    
    $user = User::create([
        'name' => $req->name,
        'email' => $req->email,
        'mobile'=>$req->phone,
        'password' => Hash::make($req->password), // Hashing the password
    ]);

    if ($user) {
        return response()->json([
            'status' => true,
            'status_code' => '200',
            'message' => 'User signed up successfully',
        ], 200);
    } else {
        return response()->json([
            'status' => false,
            'status_code' => '400',
            'message' => 'User creation failed',
        ], 400);
    }
    }
    }

        public function login(Request $req){
            $validated = $req->validate([
                'password'=>'required',
            ]);
            if($validated)
{
            if(Auth::attempt(['email'=>$req->email ?? null,'password'=>$req->password]) || Auth::attempt(['mobile'=>$req->phone ?? null,'password'=>$req->password])){
                  $user = Auth::user();

        // Delete previous tokens
        $user->tokens()->delete();

                return response()->json([
                    'status'=>true,
                    'status_code' => '200',
                    'message'=>'user logged in successfully',
                    'token'=>Auth::user()->createToken('API Token')->plainTextToken,
                    'token_type'=>'bearer',
                    'user'=>Auth::user(),
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'status_code' => '400',
                    'message'=>'user not found, please register',
                ],400);
            }
        }else{
             return response()->json([
                    'status'=>false,
                    'status_code' => '400',
                    'message'=>'validation fail',
                    'error'=>$validated->errors()->all(),
                ],400);
        }
        }

        public function logout(Request $req){
      
            
            $validated = $req->validate([
                'user_id'=>'required',
            ]);
            
            $user = User::find($req->user_id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                     'status_code' => 404,
                    'message' => 'User not found',
                ], 404);
            }
        
            // Delete all tokens or current token
            $user->tokens()->delete(); // For all tokens
            // $request->user()->currentAccessToken()->delete(); // For only current device
        
            return response()->json([
                'status' => true,
                 'status_code' => 200,
                'message' => 'User logged out successfully',
            ], 200);
        }
        public function changePassword(Request $req)
{
    // Validate request
    $req->validate([
        'user_id' => 'required|exists:users,id',
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed', // Needs new_password_confirmation
    ]);

    $user = User::find($req->user_id);

    // Check if old password matches
    if (!Hash::check($req->old_password, $user->password)) {
        return response()->json([
            'status' => false,
            'status_code' => 400,
            'message' => 'Old password is incorrect',
        ], 400);
    }

    // Update password
    $user->password = Hash::make($req->new_password);
    $user->save();

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'Password changed successfully',
    ], 200);
}

}
