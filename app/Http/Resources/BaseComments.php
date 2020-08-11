<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseComments extends JsonResource
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
            'comment'   => $this->comment,
            'date'      => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
