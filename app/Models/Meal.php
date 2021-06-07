<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

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

    public function x()
    {
        dd(1);
    }
    // public static function updateQuestion($id, $datas)
    // {
    //     $optionQuestionIds = [];

    //     foreach ($datas as $data) {
    //         $optionQuestion = OptionQuestion::updateOrCreate(
    //             [
    //                 'question' => $data['question'],
    //                 'question_degree' => $data['question_degree'],
    //                 'adjust_standar_id' => $id,
    //             ],
    //             [
    //                 'question' => $data['question'],
    //                 'question_degree' => $data['question_degree'],
    //                 'adjust_standar_id' => $id,
    //             ]
    //         );
    //         $optionQuestion->save();
    //         $optionQuestionIds[] = $optionQuestion->id;
    //     }

    //     OptionQuestion::where('adjust_standar_id', $id)->whereNotIn('id', $optionQuestionIds)->delete();
    // }

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
