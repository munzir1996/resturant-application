<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\Client\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ResturantResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'commercial_registration_no' => $this->commercial_registration_no,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'delivery' => $this->delivery,
            'client' => $this->whenLoaded('client'),

            'category' => new CategoryResource($this->whenLoaded('category')),
            'resturant_location' => $this->whenLoaded('resturantLocation'),
            'banks' => $this->whenLoaded('banks'),
        ];
    }
}




