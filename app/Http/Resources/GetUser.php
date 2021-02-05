<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Gate;


class GetUser extends JsonResource
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
            'about_as'      => $this->about_as,
            'avatar'        => $this->avatar,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'birthday'      => $this->birthday,
            'facebook'      => $this->facebook,
            'instagram'     => $this->instagram,
            'branch'        => $this->branches->map->only('id', 'name'),
            'role'          => $this->roles->map->only('id', 'title'),
            'updated_at'    => Carbon::parse($this->updated_at)->translatedFormat('d.m.Y H:m:s'),
            'last_online_at'    => Carbon::parse($this->last_online_at)->translatedFormat('d.m.Y H:m:s'),
        ];
    }
}
