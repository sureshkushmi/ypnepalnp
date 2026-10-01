<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Listing extends Model
{
    protected $table = 'listings';

    public $timestamps = false;

 protected $fillable = [
    'name',
    'cityId',
    'add1',
    'add2',
    'email',
    'pobox',
    'phone1',
    'phone2',
    'fax',
    'url',
    'description',
    'image',
    'logo',
    'status',
    'galleryStatus',
    'isPaid',
    'visited',
    'onDate',
    'udate',
    'market_by',
    'expiry_date',
    'amount',
    'listing_color',
    'listing_size',
    'latitude',
    'longitude',
    'contact_person',
];

    protected $casts = [
        'onDate' => 'date',
        'udate' => 'date',
        'expiry_date' => 'date',
        'visited' => 'integer',
        'market_by' => 'integer',
        'amount' => 'integer',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'cityId');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'listingcategories',
            'listingId',
            'catId'
        );
    }
}