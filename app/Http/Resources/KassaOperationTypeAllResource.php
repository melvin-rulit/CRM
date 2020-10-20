<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KassaOperationTypeAllResource extends JsonResource
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
            'id'	    => $this->id,
            'name'	    => $this->name,
            'branch'	=> $this->branch->name,
            'group'	    => $this->group ? $this->group->name : '',
            'coming'	=> $this->coming,
            'out'	    => $this->out,
            'cash'	    => $this->cash,
            'beznal'	=> $this->beznal,
            'coment'	=> $this->coment,
        ];
    }
}
