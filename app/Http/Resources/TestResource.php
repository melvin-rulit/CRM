<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'products'               => $this->base_branch->products,
            'child_surname'          => $this->child_surname,
            'child_name'             => $this->child_name,
            'child_middle_name'      => $this->child_middle_name,
        ];
    }
}
