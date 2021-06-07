<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealAddon extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the meal that owns the MealAddon
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
