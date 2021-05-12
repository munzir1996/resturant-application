<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResturantLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the country that owns the ResturantLocation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the ResturantLocation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the resturant that owns the ResturantLocation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }


}



