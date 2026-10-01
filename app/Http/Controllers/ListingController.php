<?php

namespace App\Http\Controllers;
use App\Models\Listing;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        return response()->json(
            Listing::with(['city', 'categories'])->paginate(20)
        );
    }

    public function publicIndex(Request $request)
    {
        $listings = Listing::query()
            ->with(['city', 'categories'])
            ->where('status', 'A')
            ->when($request->input('featured') == 1, function ($query) {
                $query->where('isPaid', 'Y')
                    ->where(function ($q) {
                        $q->whereNull('expiry_date')
                            ->orWhereDate('expiry_date', '>=', now()->toDateString());
                    });
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Public/Listings/Index', [
            'listings' => $listings,
        ]);
    }

    

    public function publicShow(Listing $listing)
    {
        abort_unless($listing->status === 'A', 404);

        $listing->load(['city', 'categories']);

        // related listings sharing the same category, excluding this one
        $related = collect();

        if ($listing->categories->isNotEmpty()) {
            $related = Listing::query()
                ->with('city')
                ->where('status', 'A')
                ->where('id', '!=', $listing->id)
                ->whereHas('categories', function ($q) use ($listing) {
                    $q->whereIn('categories.id', $listing->categories->pluck('id'));
                })
                ->latest('id')
                ->limit(4)
                ->get();
        }

        return Inertia::render('Public/Listings/Show', [
            'listing' => $listing,
            'related' => $related,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'cityId' => ['required', 'integer', 'exists:cities,id'],
            'add1' => ['required', 'string', 'max:250'],
            'add2' => ['nullable', 'string', 'max:250'],
            'email' => ['nullable', 'email', 'max:50'],
            'phone1' => ['required', 'string', 'max:50'],
            'phone2' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'],
            'url' => ['nullable', 'string', 'max:250'],
            'description' => ['nullable', 'string'],
            'contact_person' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['status'] = 'A';
        $validated['galleryStatus'] = 'D';
        $validated['isPaid'] = 'N';
        $validated['visited'] = 0;
        $validated['onDate'] = now()->toDateString();

        $listing = Listing::create($validated);

        return response()->json([
            'message' => 'Listing created successfully.',
            'data' => $listing,
        ], 201);
    }

    public function show(Listing $listing)
    {
        return response()->json(
            $listing->load(['city', 'categories'])
        );
    }
}