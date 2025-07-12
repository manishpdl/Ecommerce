<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        // Validate the request
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        $user=Auth::attempt($data);
        if (!$user) {
            return response()->json(['message' => 'Invalid credentials','success'=>false,], 401);

           }
        // Generate a token for the user
        $token = Auth::user()->createToken('auth_token')->plainTextToken;

        // Return the token and user information
        return response()->json([
            'message' => 'Login successful',
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }
}
