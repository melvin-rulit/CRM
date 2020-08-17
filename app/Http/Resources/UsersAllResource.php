<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use Cache;


class UsersAllResource extends JsonResource
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
            'name'          => $this->name,
            'surname'       => $this->surname,
            'email'         => $this->email,
            'branches'      => $this->branches,
            'roles'         => $this->roles,
            'online'        => Cache::has('user-is-online-' . $this->id),
        ];
    }
}
