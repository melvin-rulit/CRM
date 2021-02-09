<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseArticleResource extends JsonResource
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
            'article'                   => $this->article,
            'group'                     => $this->article->article_group,
            'warehouse'                 => $this->warehouse,
            'supplier'                  => $this->supplier,
            'quantity'                  => $this->quantity,
        ];
    }
}
