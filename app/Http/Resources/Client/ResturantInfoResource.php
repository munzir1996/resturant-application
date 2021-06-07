<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ResturantInfoResource extends JsonResource
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
            'services' => $this->services,
            'maximum_delivery_distance' => $this->maximum_delivery_distance,
            'neighborhood_delivery_price' => $this->neighborhood_delivery_price,
            'outside_neighborhood_delivery_price' => $this->outside_neighborhood_delivery_price,
            'minimum_purchase_free_delivery_in_neighborhood' => $this->minimum_purchase_free_delivery_in_neighborhood,
            'minimum_purchase_free_delivery_outside_neighborhood' => $this->minimum_purchase_free_delivery_outside_neighborhood,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'accepted_payment_methods' => $this->accepted_payment_methods,
            'loyalty_points' => $this->loyalty_points,
            'customer_earn_points' => $this->customer_earn_points,

            'latitude' => $this->resturantLocation->latitude,
            'longetitue' => $this->resturantLocation->longetitue,
            'categories' => $this->whenLoaded('categories'),
        ];
    }
}
