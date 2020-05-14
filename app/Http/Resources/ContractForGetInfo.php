<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractForGetInfo extends JsonResource
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
            'id'                  => $this->id,
            'name'                => $this->name,
            'start'               => $this->start,
            'end'                 => $this->end,
            'end_actually'        => $this->end_actually,
            'freezing_total'      => $this->freezing_total,
            'classes_total'       => $this->classes_total,
            'active'              => $this->active,
            'pays'                => $this->contract_pays,
        ];
    }
}
