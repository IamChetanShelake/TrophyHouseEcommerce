<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\cartItem;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $categories = AwardCategory::with('products')->get();
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0;
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $pages = Page::all();
       
        return view('website.editProfile', compact('categories', 'cart_items', 'wishlist_count', 'pages'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // ✅ Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('profile_images'), $imageName);

            // Delete old image (optional)
            if ($user->profile_img && File::exists(public_path('profile_images/' . $user->profile_img))) {
                File::delete(public_path('profile_images/' . $user->profile_img));
            }

            $user->profile_img = $imageName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // public function update(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'password' => 'nullable|min:6',
    //         'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     $user->name = $request->name;
    //     $user->email = $request->email;

    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //     }

    //     if ($request->hasFile('profile_image')) {
    //         $imageName = time() . '.' . $request->profile_image->extension();
    //         $request->profile_image->move(public_path('profile_images'), $imageName);
    //         $user->profile_image = $imageName;
    //     }

    //     $user->save();

    //     return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    // }
}
