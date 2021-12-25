<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $country = $this->whenLoaded('country') ?? [];

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'country_id' => $this->country_id,
            'country_code' => $this->country_code,
            'iso2' => $this->iso2,
            'country' => new CountryResource($country),
        ];
        return $data;
    }
}
