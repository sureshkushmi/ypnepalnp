<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $cityId = $request->input('city_id');
        $categoryId = $request->input('category_id');

        $listings = Listing::query()
            ->with(['city', 'categories'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone1', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($cityId, function ($query, $cityId) {
                $query->where('cityId', $cityId);
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Listings/Index', [
            'listings' => $listings,
            'cities' => City::query()
                ->orderBy('name')
                ->get(['id', 'name']),
            'categories' => Category::query()
                ->orderBy('name')
                ->get(['id', 'name']),
            'filters' => [
                'search' => $search,
                'city_id' => $cityId,
                'category_id' => $categoryId,
            ],
        ]);
    }
}