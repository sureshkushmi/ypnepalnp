<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $listings = Listing::query()
            ->with(['city', 'categories'])
            ->where('status', 'A')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($search) use ($q) {

                    // Business name
                    $search->where('name', 'like', "%{$q}%")

                        // Address
                        ->orWhere('add1', 'like', "%{$q}%")
                        ->orWhere('add2', 'like', "%{$q}%")

                        // Description
                        ->orWhere('description', 'like', "%{$q}%")

                        // Phone
                        ->orWhere('phone1', 'like', "%{$q}%")
                        ->orWhere('phone2', 'like', "%{$q}%")

                        // Category
                        ->orWhereHas('categories', function ($category) use ($q) {
                            $category->where('name', 'like', "%{$q}%");
                        })

                        // City
                        ->orWhereHas('city', function ($city) use ($q) {
                            $city->where('name', 'like', "%{$q}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Public/Search/Index', [
            'query' => $q,
            'listings' => $listings,
        ]);
    }
}