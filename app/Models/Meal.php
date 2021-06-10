<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['mealAddons'];

    public function storeMealAddons($mealAddons)
    {
        foreach ($mealAddons as $mealAddon) {
            MealAddon::create([
                'name' => $mealAddon['name'],
                'price' => $mealAddon['price'],
                'meal_id' => $this->id,
            ]);
        }
    }

    public function updateMealAddons($mealAddons)
    {
        $mealAddonsIds = [];
        if (!empty($mealAddons)) {
            foreach ($mealAddons as $mealAddon) {
                $mealAddon = MealAddon::updateOrCreate(
                    [
                        'name' => $mealAddon['name'],
                        'price' => $mealAddon['price'],
                        'meal_id' => $this->id,
                    ],
                    [
                        'name' => $mealAddon['name'],
                        'price' => $mealAddon['price'],
                        'meal_id' => $this->id,
                    ]
                );

                $mealAddon->save();
                $mealAddonsIds[] = $mealAddon->id;
            }

            MealAddon::where('meal_id', $this->id)->whereNotIn('id', $mealAddonsIds)->delete();
        } else {
            $this->mealAddons()->delete();
        }
    }

    /**
     * Get the classification that owns the Meal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }

    /**
     * Get all of the mealAddons for the Meal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mealAddons()
    {
        return $this->hasMany(MealAddon::class);
    }
}
