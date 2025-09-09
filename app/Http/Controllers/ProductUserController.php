<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProductUserController extends Controller
{
    /**
     * Display a listing of product users.
     */
    public function index(Request $request)
    {
        $users = User::where('role', 3)->orderBy('created_at', 'desc')->paginate(500);
        return view('admin.product-user.index', compact('users'));
    }

    /**
     * Show the form for creating a new product user.
     */
    public function create()
    {
        return view('admin.product-user.create');
    }

    /**
     * Store a newly created product user in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateUserData($request);

        $userData = $this->prepareUserData($request, $validatedData);
        $userData['role'] = 3;

        $this->handleProfileImage($request, $userData);

        User::create($userData);

        return redirect()->route('admin.product-user.index')->with('success', 'Product user created successfully!');
    }

    /**
     * Show the form for editing the specified product user.
     */
    public function edit($id)
    {
        $user = User::where('role', 3)->findOrFail($id);
        return view('admin.product-user.edit', compact('user'));
    }

    /**
     * Update the specified product user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 3)->findOrFail($id);
        $validatedData = $this->validateUserData($request, $user->id);

        $userData = $this->prepareUserData($request, $validatedData, $user);

        $this->handleProfileImage($request, $userData, $user);

        $user->update($userData);

        return redirect()->route('admin.product-user.index')->with('success', 'Product user updated successfully!');
    }

    /**
     * Remove the specified product user from storage.
     */
    public function destroy($id)
    {
        $user = User::where('role', 3)->findOrFail($id);
        $this->deleteProfileImage($user);
        $user->delete();

        return redirect()->route('admin.product-user.index')->with('success', 'Product user deleted successfully!');
    }

    /**
     * Validate user data from the request.
     */
    private function validateUserData(Request $request, $userId = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . ($userId ?? 'NULL'),
            'mobile' => 'required|string|max:15|unique:users,mobile,' . ($userId ?? 'NULL'),
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|max:2048',
        ];

        return $request->validate($rules);
    }

    /**
     * Prepare user data for creation or update.
     */
    private function prepareUserData(Request $request, array $validatedData, $user = null)
    {
        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'] ?? null,
            'mobile' => $validatedData['mobile'],
        ];

        if (isset($validatedData['password'])) {
            $data['password'] = Hash::make($validatedData['password']);
        } elseif ($user) {
            $data['password'] = $user->password; // Keep existing password
        }

        return $data;
    }

    /**
     * Handle profile image upload or update.
     */
    // private function handleProfileImage(Request $request, array &$userData, $user = null)
    // {
    //     if ($request->hasFile('profile_image')) {
    //         if ($user && $user->profile_image && file_exists(public_path('users/' . basename($user->profile_image)))) {
    //             unlink(public_path('users/' . basename($user->profile_image)));
    //         }

    //         $imageName = time() . '_' . Str::random(10) . '.' . $request->file('profile_image')->getClientOriginalExtension();
    //         $request->file('profile_image')->move(public_path('users'), $imageName);
    //         $userData['profile_img'] = 'users/' . $imageName;
    //     } elseif ($user) {
    //         $userData['profile_img'] = $user->profile_image; // Keep existing image
    //     }
    // }

    // private function handleProfileImage(Request $request, array &$data, $user = null)
    // {
    //     if ($request->hasFile('profile_image')) {
    //         if ($user && $user->profile_img) {
    //             unlink(public_path('images/' . $user->profile_img));
    //         }
    //         $filename = time() .  '.' . $request->file('profile_image')->Extension();
    //         $request->file('profile_image')->move('profile_image', $filename);
    //         $data['profile_img'] = $filename; // Store only the image name
    //     } elseif ($user) {
    //         $data['profile_img'] = $user->profile_image; // Keep existing image name
    //     }
    // }

    private function handleProfileImage(Request $request, array &$data, $user = null)
    {
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user && $user->profile_img && file_exists(public_path('profile_image/' . $user->profile_img))) {
                unlink(public_path('profile_image/' . $user->profile_img));
            }

            // Generate new file name
            $filename = time() . '.' . $request->file('profile_image')->getClientOriginalExtension();

            // Move the uploaded file to 'public/profile_image' folder
            $request->file('profile_image')->move('profile_image', $filename);

            // Store only the file name in the database
            $data['profile_img'] = $filename;
        } elseif ($user) {
            // Keep existing image name if no new file is uploaded
            $data['profile_img'] = $user->profile_img;
        }
    }


    /**
     * Delete the profile image if it exists.
     */
    private function deleteProfileImage($user)
    {
        if ($user->profile_image && file_exists(public_path('users/' . basename($user->profile_image)))) {
            unlink(public_path('users/' . basename($user->profile_image)));
        }
    }
}
