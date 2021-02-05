<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Gate;

class RegionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'branches'      => $this->branches->map->only('id', 'name'),
        ];
    }

}
