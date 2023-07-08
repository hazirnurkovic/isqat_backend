<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditChallengeRequest;
use App\Http\Requests\StoreChallengeRequest;
use App\Models\Challenge;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Challenge::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChallengeRequest $request)
    {
        $validated_data = $request->validated();
        return Challenge::create($validated_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Challenge $challenge)
    {
        return $challenge;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Challenge $challenge)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditChallengeRequest $request, Challenge $challenge)
    {
        $validated_data = $request->validated();
        $challenge->update($validated_data);

        return $challenge;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Challenge $challenge)
    {
       return $challenge->delete();
    }

}
