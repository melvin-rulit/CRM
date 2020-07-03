<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetUserInGroupResource extends JsonResource
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

            'id'                =>  $this->id,
            'child_surname'     =>  $this->child_surname,
            'child_name'        =>  $this->child_name,
            'group_id'          =>  $this->group_id,
            'journal'           =>  $this->journal

        ];
    }
}
