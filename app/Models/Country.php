<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['cities'];

    /**
     * Get all of the cities for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get all of the resturantLocations for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resturantLocations()
    {
        return $this->hasMany(ResturantLocation::class);
    }
}
