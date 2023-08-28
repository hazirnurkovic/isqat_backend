<?php

namespace App\Services;

use Illuminate\Http\Request;

class UserService
{

    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function getUserChallenges()
    {
        
        return $this->user->checkChallengeAvailability();
    }

    public function getUserChallenge($challengeId)
    {
        return $this->user->getUserChallenge($challengeId);        
    }

    public function updateUserChallenge(Request $request)
    {
        return $this->user->updateUserChallenge($request->challenge_id);

    }
}