<?php

namespace App\Http\Controllers;

use App\Models\City;
use Inertia\Inertia;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::query()
            ->withCount('listings')
            ->orderBy('name')
            ->get();

        return Inertia::render('Public/Locations/Index', [
            'cities' => $cities,
        ]);
    }

    public function show(City $city)
    {
        $listings = $city->listings()
            ->with('categories')
            ->where('status', 'A')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Public/Locations/Show', [
            'city'     => $city,
            'listings' => $listings,
        ]);
    }
}