<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ArticleResource extends JsonResource
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
            'article_group'     => $this->article_group ? $this->article_group->name : null,
            'supplier'          => $this->supplier ? $this->supplier->name : null,
            'description'       => $this->description,
        ];
    }

}
