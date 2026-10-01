<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Listing;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Featured businesses
        $featuredListings = Listing::query()
            ->with(['city', 'categories'])
            ->where('status', 'A')
            ->where('isPaid', 'Y')
            ->where(function ($query) {
                $query->whereNull('expiry_date')
                    ->orWhereDate('expiry_date', '>=', now()->toDateString());
            })
            ->orderByDesc('id')
            ->take(6)
            ->get();

        // Main categories
        $categories = Category::query()
            ->withCount('listings')
            ->orderBy('name')
            ->take(12)
            ->get();

        // Popular cities
        $cities = City::query()
            ->withCount('listings')
            ->orderByDesc('listings_count')
            ->take(10)
            ->get();

        return Inertia::render('Home', [
            'featuredListings' => $featuredListings,
            'categories' => $categories,
            'cities' => $cities,
        ]);
    }
}