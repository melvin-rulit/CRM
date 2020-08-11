<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsInBranch extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'price'             => $this->price,
            'price_title'       => $this->price_title,
            'classes_total'     => $this->classes_total,
            'classes_week'      => $this->classes_week,
            'category_time'     => $this->category_time,
            'freezing_total'    => $this->freezing_total,
            'active'            => $this->active,
            'branch_id'         => $this->branch_id,
            'months'            => $this->months,
            'days'              => $this->days,
            'freezing_kolvo'    => $this->freezing_kolvo,
            'date_end'          => $this->date_end,
            'product_active'    => $this->date_end > Carbon::today()->toDateString() ? true : false,
        ];
    }
}
