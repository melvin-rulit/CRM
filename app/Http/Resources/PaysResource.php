<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaysResource extends JsonResource
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
            'id'            => $this->id,
            'contract_id'   => $this->contract_id,
            'pay'           => $this->pay,
            'day'           => $this->day,
            'date'          => Carbon::createFromDate($this->date)->format('d.m.Y'),
        ];
    }
}
