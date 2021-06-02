<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ResturantBasicInfoResource extends JsonResource
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
            'name_en' => $this->when(isset($this->name_en), $this->name_en),
            'manager_name' => $this->manager_name,
            'manager_phone' => $this->manager_phone,
            'email' => $this->email,
            'commercial_registration_no' => $this->commercial_registration_no,
            'client_id' => $this->client_id,
        ];
    }
}
