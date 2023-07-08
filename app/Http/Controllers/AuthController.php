<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function verifyToken(Request $request)
    {
        $token = $request->input('token');

        // Find the user with the provided token
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            // Token is invalid or not found in the database
            return response()->json(['valid' => false]);
        }

        // Token is valid
        return response()->json(['valid' => true]);
    }
}
