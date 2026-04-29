<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's profile.
     */
        public function index()
    {
        // Returns all users from your sqlite database
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,user',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
        ]);

        return response()->json($user, 201);
    }

    public function show()
    {
        // returns the currently logged-in user (from the Sanctum token)
        return response()->json(Auth::user());
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validate the incoming data from Vue
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'    => 'nullable|string|max:20',
            'bio'      => 'nullable|string|max:500',
            // Allow them to update password only if they provide one
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Handle Password Hashing if a new one is provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            // Remove password from array if not being updated
            unset($validated['password']);
        }

        // 3. Update the database record
        $user->update($validated);

        // 4. Return response structured for your Vue globalState
        return response()->json([
            'message' => 'Profile updated successfully!',
            'user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'fullName' => $user->name,
                'email'    => $user->email,
                'role'     => $user->role,
                'phone'    => $user->phone,
                'bio'      => $user->bio,
            ]
        ]);
    }
}