<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'classification_id' => $this->classification_id,
            'price' => $this->price,
            'detail' => $this->detail,
            'calorie' => $this->calorie,
            'size' => $this->size,
            'additions' => $this->additions,
        ];
    }
}


