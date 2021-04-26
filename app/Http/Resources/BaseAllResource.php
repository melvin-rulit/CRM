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
                'age' => Carbon::createFromDate($this->birthday)->diff(Carbon::now())->format('%y,%m'),
        ];
    }
}
