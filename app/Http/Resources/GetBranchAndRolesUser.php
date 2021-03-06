<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetBranchAndRolesUser extends JsonResource
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
            'roles'      => $this->userAccess->map->only('id', 'title'),
            'branches' => $this->branches->map->only('id', 'name'),
        ];
    }
}
