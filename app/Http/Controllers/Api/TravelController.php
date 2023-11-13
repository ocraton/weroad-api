<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TravelResource::collection(Travel::where('isPublic', true)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTravelRequest $request)
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTravelRequest $request, Travel $travel)
    {
        $travel->update($request->validated());

        return new TravelResource($travel);
    }
}
