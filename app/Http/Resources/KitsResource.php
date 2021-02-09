<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class KitsResource extends JsonResource
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
            'article'       => $this->warehouse_article->article->name,
            'surname'       => $this->user->surname,
            'name'          => $this->user->name,
            'quantity'      => $this->quantity,
            'date'          => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
