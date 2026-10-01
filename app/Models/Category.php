<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'parentId',
        'visited',
        'onDate',
    ];

    protected $casts = [
        'parentId' => 'integer',
        'visited' => 'integer',
        'onDate' => 'date',
    ];

    public function listings(): BelongsToMany
    {
        return $this->belongsToMany(
            Listing::class,
            'listingcategories',
            'catId',
            'listingId'
        );
    }
}