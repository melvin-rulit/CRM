<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'date'                => Carbon::createFromDate($this->date)->format('d.m.Y'),
            'start'               => Carbon::createFromDate($this->start)->format('d.m.Y'),
            'end'                 => Carbon::createFromDate($this->end)->format('d.m.Y'),
            'end_actually'        => Carbon::createFromDate($this->end_actually)->format('d.m.Y'),
            'freezing_total'      => $this->freezing_total,
            'classes_total'       => $this->classes_total,
            'active'              => $this->active,
            'pays'                => $this->contract_pays,
        ];
    }
}
