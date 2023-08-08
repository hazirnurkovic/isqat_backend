<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_admin',
        'challenge_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isChallengeAvailable()
    {
        $today = Carbon::now()->format('Y-m-d');
        $user_updated = !empty($this->update_user) ? Carbon::parse($this->update_user)->format('Y-m-d') : '1999-01-01';

        if ($this->challenge_id == 1 || $this->challenge_id == null) 
        {
            return 
            [
                'challenge_id' => 1,
                'disabled' => false
            ];
        }

        if ($today > $user_updated) 
        {
            return 
            [
                'challenge_id' => $this->challenge_id,
                'disabled' => false
            ];
        }

        return 
        [
            'challenge_id' => $this->challenge_id,
            'disabled' => true
        ];
    }

    public function updateUserChallenge($challengeId)
    {
        $this->challenge_id = $this->challenge_id ?? 1;
        $message = Message::find($this->challenge_id)->pluck("messages")->first();
        
        if ($challengeId < $this->challenge_id) {
            return [
                'message' => "Drago nam je da si se vratio/la ponovo da riješiš ovaj zadatak!",
                'user' => $this,
                'token' => $this->remember_token
            ];
        }
        $today = Carbon::now()->format('Y-m-d');
        try {
            $this->challenge_id++;
            $this->update_user = $today;
            $this->save();

            return [
                'message' => $message,
                'user' => $this,
                'token' => $this->remember_token
            ];
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function getUserChallenge($challengeId)
    {
        $challenge = Challenge::find($challengeId);
        $alternative_challenge = AlternativeChallenge::find($challengeId);

        return [
            "challenge" => $challenge,
            "alternative_challenge" => $alternative_challenge
        ];
    }
}
