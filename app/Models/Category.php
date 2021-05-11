<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['subcategories'];

    /**
     * Get all of the subcategories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Get all of the resturants for the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resturants()
    {
        return $this->hasMany(Resturant::class);
    }

}
