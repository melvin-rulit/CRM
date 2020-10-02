<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class BaseAllResource extends JsonResource
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
                'id'                     => $this->id,
                'child_surname'          => $this->child_surname,
                'child_name'             => $this->child_name,
                'child_middle_name'      => $this->child_middle_name,
                'age' => Carbon::createFromDate($this->child_birthday)->diff(Carbon::now())->format('%y,%m'),
                'statuses' => $this->statuses,
                'steps' => $this->statuses->steps->name,
                'status' => $this->statuses->status->name,
                'color' => $this->statuses->status->color,
                'steps_color' => $this->statuses->steps->color,
                'call_date' => Carbon::createFromDate($this->statuses->call_date)->format('d.m.Y h:i'),
        ];
    }
}
