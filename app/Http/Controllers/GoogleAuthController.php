<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;

use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // function for redirect
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    // for handling google callback
    public function callbackGoogle()
{
    try {
        $google_User = Socialite::driver('google')->user();

        // Check if user exists with google_id
        $user = User::where('google_id', $google_User->getId())->first();

        if (!$user) {
            // If not, check if user exists with email
            $user = User::where('email', $google_User->getEmail())->first();

            if ($user) {
                // User exists but not linked with Google, so update google_id
                $user->update([
                    'google_id' => $google_User->getId(),
                ]);
            } else {
                // New user, create one
                $user = User::create([
                    'name' => $google_User->getName(),
                    'email' => $google_User->getEmail(),
                    'google_id' => $google_User->getId(),
                ]);
            }
        }

        // Log the user in
        Auth::login($user);
        return redirect()->intended('home');

    } catch (Exception $e) {
        dd('Something went wrong: ' . $e->getMessage());
    }
}
    // public function callbackGoogle()
    // {
    //     try {
    //         $google_User = Socialite::driver('google')->user();
    //         // check if user already exists
    //         $user=User::where('google_id', $google_User->getId())->first();

    //         //if user dosent exits
    //         if (!$user) {
    //             // create new user
    //             $new_user = User::create([
    //                 'name' => $google_User->getName(),
    //                 'email' => $google_User->getEmail(),
    //                 'google_id' => $google_User->getId(),

    //             ]);
    //             // used auth class
    //             Auth::login($new_user);
    //             //return redirect()->route('home')->with('success', 'User created successfully and logged in.');
    //             return redirect()->intended('home');
    //         }
    //         else {
    //             // if user exists then login
    //             Auth::login($user);
    //             //return redirect()->route('home')->with('success', 'User logged in successfully.');
    //             return redirect()->intended('home');
    //         }

    //     } catch (\Exception $e) {
    //         dd('Something went wrong: ' . $e->getMessage());

    //     }
    // }
}
