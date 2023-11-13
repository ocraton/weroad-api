<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListTourRequest;
use App\Http\Requests\StoreTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListTourRequest $request, Travel $travel)
    {
        $tours = $travel->tours()
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('startingDate', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('startingDate', '<=', $request->dateTo);
            })
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo * 100);
            })
            ->when($request->sortBy && $request->orderBy, function ($query) use ($request) {
                $query->orderBy($request->sortBy, $request->orderBy);
            })
            ->orderBy('startingDate')
            ->paginate();

        return TourResource::collection($tours);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTourRequest $request)
    {
        $tour = Tour::create($request->validated());

        return new TourResource($tour);
    }
}
