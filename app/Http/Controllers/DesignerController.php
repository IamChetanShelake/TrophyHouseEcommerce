<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductUserController extends Controller
{
    // List all product users
    public function index()
    {
        $users = User::where('role', 3)->latest()->paginate(500);
        return view('admin.product-user.index', compact('users'));
    }

    // Show form to create a new product user
    public function create()
    {
        return view('admin.product-user.create');
    }

    // Store a new product user
    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['role'] = 3;
        $this->handleProfileImage($request, $data);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        User::create($data);
        return redirect()->route('admin.product-user.index')->with('success', 'Product user created successfully!');
    }

    // Show form to edit an existing product user
    public function edit($id)
    {
        $user = User::where('role', 3)->findOrFail($id);
        return view('admin.product-user.edit', compact('user'));
    }

    // Update an existing product user
    public function update(Request $request, $id)
    {
        $user = User::where('role', 3)->findOrFail($id);
        $data = $this->validateData($request, $user->id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $this->handleProfileImage($request, $data, $user);
        $user->update($data);
        return redirect()->route('admin.product-user.index')->with('success', 'Product user updated successfully!');
    }

    // Delete a product user
    public function destroy($id)
    {
        $user = User::where('role', 3)->findOrFail($id);
        $this->deleteProfileImage($user);
        $user->delete();
        return redirect()->route('admin.product-user.index')->with('success', 'Product user deleted successfully!');
    }

    // Validate user data
    private function validateData(Request $request, $userId = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . ($userId ?: 'NULL'),
            'mobile' => 'required|string|max:15|unique:users,mobile,' . ($userId ?: 'NULL'),
            'password' => $userId ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|max:2048',
        ]);
    }

    // Handle profile image upload
    private function handleProfileImage(Request $request, array &$data, $user = null)
    {
        if ($request->hasFile('profile_image')) {
            if ($user && $user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }
            $filename = time() . '_' . Str::random(10) . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->move('profile_image', $filename);
            $data['profile_image'] = 'profile_image/' . $filename;
        } elseif ($user) {
            $data['profile_image'] = $user->profile_image;
        }
    }

    // Delete profile image from storage
    private function deleteProfileImage($user)
    {
        if ($user->profile_image && file_exists(public_path($user->profile_image))) {
            unlink(public_path($user->profile_image));
        }
    }
}
