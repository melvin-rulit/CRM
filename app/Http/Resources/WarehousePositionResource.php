<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehousePositionResource extends JsonResource
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
            'id'                        => $this->id,
            'name'                      => $this->name,
            'quantity'                  => $this->quantity,
            'description'               => $this->description,
            'warehouse_group_id'        => $this->warehouse_group_id,
            'warehouse_group_name'      => $this->warehouse_group->name,
            'warehouse_id'              => $this->warehouse_id,
            'warehouse_name'            => $this->warehouse->name,
            'supplier_id'               => $this->supplier->id,
            'supplier_name'             => $this->supplier->name,
        ];
    }
}
