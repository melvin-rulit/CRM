<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseLogResource extends JsonResource
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
            'id'        => $this->id,
            'user'      => $this->user->surname . ' ' . $this->user->name,
            'comment'   => $this->message,
            'date'      => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
