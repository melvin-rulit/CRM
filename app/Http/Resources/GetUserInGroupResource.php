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
            'parent_surname'    => ($this->mother_lpr) ? $this->mother_surname : (($this->father_lpr) ? $this->father_surname : $this->other_relative_surname),
            'parent_name'       => ($this->mother_lpr) ? $this->mother_name : (($this->father_lpr) ? $this->father_name : $this->other_relative_name),
            'parent_phone'      => ($this->mother_lpr) ? $this->mother_phone : (($this->father_lpr) ? $this->father_phone : $this->other_relative_phone),
            'parent_type'       => ($this->mother_lpr) ? 'Мать' : (($this->father_lpr) ? 'Отец' : 'Другой родственник'),
            'group_id'          =>  $this->group_id,
            'journal'           =>  $this->journal

        ];
    }
}
