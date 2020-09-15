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
            'child_surname'     => $this->child_surname . ' ' . $this->child_name,
            'child_name'        => $this->child_name,
            'programm_id'       => $this->programm_id,
            'group_id'          => $this->group_id,
            'group'             => $this->group,
            'contracts'         => $this->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()->map->only('id', 'category_time'),

        ];
    }
}
