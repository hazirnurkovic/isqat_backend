<?php

namespace App\Services;

use Illuminate\Http\Request;

class UserService
{
    public function getUserChallenges()
    {
        $user = auth()->user();
        return $user->isChallengeAvailable();
    }

    public function getUserChallenge($challengeId)
    {
        $user = auth()->user();
        return $user->getUserChallenge($challengeId);        
    }

    public function updateUserChallenge(Request $request)
    {
        $user = auth()->user();
        return $user->updateUserChallenge($request->challenge_id);

    }
}