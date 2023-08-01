<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use function Pest\Laravel\json;

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


    public function logout()
    {
       auth()->user()->tokens()->delete();

       return [
            'messsage' => 'Successfully logged out.'
       ];
    }

    public function getUserChallenges(UserService $userService)
    {
        $challenges = $userService->getUserChallenges();
        
        return response()->json($challenges, 200);
    }

    public function getUserChallenge($challengeId, UserService $userService)
    {
        $challenge = $userService->getUserChallenge($challengeId);
        return response()->json($challenge, 200);
    }

    public function updateUserChallenge(Request $request, UserService $userService)
    {
       $response = $userService->updateUserChallenge($request);
       return response()->json($response, 200);
    }
}