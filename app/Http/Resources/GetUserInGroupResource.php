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
            'avatar'            =>  $this->avatar,
            'mother_surname'    =>  $this->mother_surname,
            'mother_name'       =>  $this->mother_name,
            'mother_phone'      =>  $this->mother_phone,
            'group_id'          =>  $this->group_id,
            'journal'           =>  $this->journal

        ];
    }
}
