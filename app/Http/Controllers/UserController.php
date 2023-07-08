<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
    use HasApiTokens, HasFactory;
    public function register(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);


        $user = User::create([
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->remember_token
        ], 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response()->json([
                'message' => 'Incorrect email or password'
            ], 401);
        }
        $token = $user->createToken('isqatToken')->plainTextToken;

        $user->update([
            'remember_token' => $token
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->remember_token
        ], 201);
    }


    public function logout(Request $request)
    {
       auth()->user()->tokens()->delete();

       return [
            'messsage' => 'Successfully logged out.'
       ];
    }

    public function getUserChallenges()
    {
        
        $user = auth()->user();
        $today = Carbon::now()->format('Y-m-d');
        $user_updated = Carbon::parse($user->updated_at)->format('Y-m-d');
        
        if($user->challenge_id == 1 || $user->challenge_id == null)
        {
            return response()->json([
                'challenge_id' => 1,
                'disabled' => false
            ], 200);
        }


        if ($today > $user_updated)
        {
            return response()->json([
                'challenge_id' => $user->challenge_id,
                'disabled' => false
            ], 200);
        }
    
        return response()->json([
            'challenge_id' => $user->challenge_id,
            'disabled' => true
        ], 200);
        
    }
}