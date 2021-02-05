<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GatesResource extends JsonResource
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
            'gate' =>$this->title,
        ];
    }
}
