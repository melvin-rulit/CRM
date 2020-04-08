<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'type'          => 'base-info',
            'id'            => (string)$this->id,
            'attributes'    => [
                'child_name' => $this->child_name,
                'child_surname' => $this->child_surname,
                'child_middle_name' => $this->child_middle_name,
                'child_birthday' => $this->child_birthday,
                'age' => Carbon::createFromDate($this->child_birthday)->diff(Carbon::now())->format('%y,%m'),
                'mother_phone' => $this->mother_phone,
                'mother_surname' => $this->mother_surname,
                'mother_name' => $this->mother_name,
                'mother_middle_name' => $this->mother_middle_name,
                'mother_dop_phone' => $this->mother_dop_phone,
                'mother_emai' => $this->mother_email,
            ],
        ];
    }
}
