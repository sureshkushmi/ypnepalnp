<?php

use App\Http\Controllers\Admin\ExcelImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\ListingController as FrontEndController; // frontend one
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use OpenAI\Laravel\Facades\OpenAI; // add at top with other imports
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*Route::get('/', function () {
    return redirect()->route('dashboard');
}); */

Route::get('/', [HomeController::class, 'index'])
    ->name('home');
    // Temporary AI test — delete after testing
Route::get('/test-ai', function () {
    $result = OpenAI::chat()->create([
        'model' => 'openai/gpt-oss-120b',   // ← from your model list
        'messages' => [
            ['role' => 'user', 'content' => 'Say hello in 5 words'],
        ],
    ]);

    return response($result->choices[0]->message->content);
});


Route::post('/ai-search', function () {
    $text = trim(request('q', ''));

    if ($text === '') {
        return redirect()->route('search');
    }

    try {
        $result = OpenAI::chat()->create([
            'model' => 'openai/gpt-oss-120b',
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You extract search filters for a Nepal business directory. '
                        . 'Return ONLY valid JSON: {"q": "main business/service term", '
                        . '"city": "Nepali city name or empty string"}. '
                        . 'No markdown, no explanation. Examples: '
                        . '"plumber in Kathmandu" -> {"q":"plumber","city":"Kathmandu"}; '
                        . '"hotel near lakeside" -> {"q":"hotel","city":"Pokhara"}; '
                        . '"best momo" -> {"q":"momo restaurant","city":""}',
                ],
                ['role' => 'user', 'content' => $text],
            ],
        ]);

        $data = json_decode($result->choices[0]->message->content, true);

        if (!is_array($data)) {
            $data = [];
        }

        return redirect()->route('search', array_filter([
            'q'    => $data['q'] ?? $text,
            'city' => $data['city'] ?? null,
        ]));
    } catch (\Exception $e) {
        // AI unavailable or error -> fall back to plain keyword search
        return redirect()->route('search', ['q' => $text]);
    }
})->name('ai-search');
    Route::get('/search', [SearchController::class, 'index'])
    ->name('search');

Route::get('/listings', [FrontEndController::class, 'publicIndex'])
    ->name('listings.index');

Route::get('/listing/{listing}', [FrontEndController::class, 'publicShow'])
    ->name('listing.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/category/{category}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/locations', [CityController::class, 'index'])
    ->name('locations.index');

Route::get('/city/{city}', [CityController::class, 'show'])
    ->name('city.show');


// Temporary/simple pages
Route::get('/map', function () {
    return Inertia::render('Public/Map');
})->name('map');

Route::get('/emergency', function () {
    return Inertia::render('Public/Emergency');
})->name('emergency');

Route::get('/add-listing', function () {
    return Inertia::render('Public/AddListing');
})->name('add-listing');

Route::get('/advertise', function () {
    return Inertia::render('Public/Advertise');
})->name('advertise');

Route::get('/contact', function () {
    return Inertia::render('Public/Contact');
})->name('contact');

Route::get('/about', function () {
    return Inertia::render('Public/About');
})->name('about');

Route::get('/privacy', function () {
    return Inertia::render('Public/Privacy');
})->name('privacy');

Route::get('/terms', function () {
    return Inertia::render('Public/Terms');
})->name('terms');

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/admin/listings', [
        ListingController::class,
        'index'
    ])->name('admin.listings.index');
    /*
    |--------------------------------------------------------------------------
    | Excel Import
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/excel-import', [
        ExcelImportController::class,
        'create'
    ])->name('admin.excel-import');

    Route::post('/admin/excel-import', [
        ExcelImportController::class,
        'store'
    ])->name('admin.excel-import.store');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

   
});

require __DIR__.'/auth.php';