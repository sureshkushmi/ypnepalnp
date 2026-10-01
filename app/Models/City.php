<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $table = 'cities';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'parentId',
        'onDate',
    ];

    protected $casts = [
        'onDate' => 'date',
        'parentId' => 'integer',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'cityId');
    }
}