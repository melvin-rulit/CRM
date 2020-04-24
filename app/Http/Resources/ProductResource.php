<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'price_title' => $this->price_title,
            'classes_total' => $this->classes_total,
            'classes_week' => $this->classes_week,
            'category_time' => $this->category_time,
            'freezing_total' => $this->freezing_total,
            'active' => $this->active,
        ];
    }
}
