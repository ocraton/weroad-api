<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Travel $travel)
    {
        $tours = $travel->tours()
            ->when($request->dateFrom, function () use ($request) {
                return $this->where('startingDate', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function () use ($request) {
                return $this->where('startingDate', '<=', $request->dateTo);
            })
            ->when($request->priceFrom, function () use ($request) {
                return $this->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function () use ($request) {
                return $this->where('price', '<=', $request->priceTo * 100);
            })
            ->orderBy('startingDate')
            ->paginate();

        return TourResource::collection($tours);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
