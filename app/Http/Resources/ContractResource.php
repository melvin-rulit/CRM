<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
                'id'      => (string)$this->id,
                'base_id' => $this->base_id,
                'name' => $this->name,
                'start' => $this->start,
                'end' => $this->end,
                'end_actually' => $this->end_actually,
                'active' => $this->active,
        ];
    }
}
