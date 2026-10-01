<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->withCount('listings')
            ->orderBy('name')
            ->get();

        return Inertia::render('Public/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function show(Category $category)
    {
        $listings = $category->listings()
            ->with('city')
            ->where('status', 'A')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Public/Categories/Show', [
            'category' => $category,
            'listings' => $listings,
        ]);
    }
}