<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlternativeChallengeRequest;
use App\Models\AlternativeChallenge;
use Illuminate\Http\Request;

class AlternativeChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AlternativeChallenge::all();
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
    public function store(AlternativeChallengeRequest $request)
    {
        $validated_data = $request->validated();
        return AlternativeChallenge::create($validated_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(AlternativeChallenge $alternativeChallenge)
    {
        return $alternativeChallenge;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlternativeChallenge $alternativeChallenge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlternativeChallengeRequest $request, AlternativeChallenge $alternativeChallenge)
    {
        $validated_data = $request->validated();
        return $alternativeChallenge->update($validated_data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlternativeChallenge $alternativeChallenge)
    {
        return $alternativeChallenge->delete();
    }
}
