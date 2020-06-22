<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AddChildrenGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'child_surname'     => $this->child_surname,
            'child_name'        => $this->child_name,
            'programm_id'       => $this->programm_id,
            'programm'          => $this->programm,
            'contracts'          => $this->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()->map->only('id', 'category_time'),

        ];
    }
}
