<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
{
    // 1. Validate that we actually got data
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // 2. Try to authenticate
    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        $user = Auth::user();
        
        // 3. Generate the "Access Pass" (Token)
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'username' => $user->username,
                'fullName' => $user->name,
                'role' => $user->role
            ]
        ], 200);
    }

    // 4. If authentication fails, send a clear error
    return response()->json([
        'message' => 'Invalid username or password.'
    ], 401);
}

    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}