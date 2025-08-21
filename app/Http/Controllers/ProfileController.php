<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\cartItem;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function edit()
    {
        $categories = AwardCategory::with('products')->get();
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0;
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $pages = Page::all();

        return view('website.edit_profile', compact('categories', 'cart_items', 'wishlist_count', 'pages'));
    }

    public function changePassword(){
         $categories = AwardCategory::with('products')->get();
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0;
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $pages = Page::all();

         return view('website.changePassword', compact('categories', 'cart_items', 'wishlist_count', 'pages'));
        // return view('website.changePassword');
    }


    public function updatePassword(Request $request){
         // Validate input
    $request->validate([
        'old_pass' => 'required',
        'new_pass' => 'required|min:8',
        'confirm_new_pass' => 'required|same:new_pass',
    ]);

    $user = Auth::user();

    // Check if old password matches
    if (!\Hash::check($request->old_pass, $user->password)) {
        return back()->with('error', 'old password does not match ');
    }

    // Update new password
    $user->password = \Hash::make($request->new_pass);
    $user->save();

    return back()->with('success', 'Password changed successfully!');
}

    public function update(Request $request)
    {
        $user = Auth::user();

        //  Validate input
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'password' => 'nullable|string|min:6',
            'profile_image' => 'nullable',
        ]);

        //  Update name and email
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->phone;

        //  If password is provided, update it
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        //  Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
    
            $imageName = time() . rand(1, 1000) . '.' . $image->extension();
            $image->move('profile_images', $imageName);

            // Delete old image if it exists
            $file = base_path('profile_images/' . $user->profile_img);
            
            if ($user->profile_img && is_file($file)) {
                // File::delete(public_path('profile_images/' . $user->profile_img));
                unlink($file);
            }

            $user->profile_img = $imageName;
        }

        $user->save();

        //  Refresh session so latest image is available in sidebar, header, etc.
        auth()->user()->refresh();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function uploadImage(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'profile_image' => 'required',
    ]);

    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        // $imageName = time() . '_' . $image->getClientOriginalName();
        $imageName = time() . rand(1, 1000) . '.' . $image->extension();
        $image->move('profile_images', $imageName);

        // Delete old image
        $oldimg = public_path('profile_images/' . $user->profile_img);
        if ($user->profile_img && is_file($oldimg)) {
            unlink($oldimg);
        }

        $user->profile_img = $imageName;
        $user->save();
        auth()->user()->refresh(); // important to update Auth::user() data
    }

    return redirect()->back()->with('success', 'Profile image updated successfully.');
}

}
