<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resturant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['client', 'category', 'resturantLocation', 'banks'];

    public const YES = 'yes';
    public const NO = 'no';

    /**
     * Get the client that owns the Resturant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the category that owns the Resturant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the resturantLocation associated with the Resturant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function resturantLocation()
    {
        return $this->hasOne(ResturantLocation::class);
    }

    /**
     * Get all of the banks for the Resturant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    /**
     * Get all of the resturantServices for the Resturant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resturantServices()
    {
        return $this->hasMany(ResturantService::class);
    }

}



