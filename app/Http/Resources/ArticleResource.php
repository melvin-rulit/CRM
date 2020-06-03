<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ContractForGetInfo;
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
            'id'            => (string)$this->id,
            // 'contracts_active' => ContractForGetInfo::collection($this->contracts->where('active',1)->flatten()),
            'contracts_active' => ContractForGetInfo::collection($this->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()),
            'contracts_not_active' => ContractForGetInfo::collection($this->contracts->where('end_actually', '<', Carbon::today()->toDateString())->flatten()),
            'attributes'    => [
                'child_name' => $this->child_name,
                'child_surname' => $this->child_surname,
                'child_middle_name' => $this->child_middle_name,
                'child_birthday' => $this->child_birthday,
                'age' => Carbon::createFromDate($this->child_birthday)->diff(Carbon::now())->format('%y,%m'),
                'mother_surname' => $this->mother_surname,
                'mother_name' => $this->mother_name,
                'mother_middle_name' => $this->mother_middle_name,
                'mother_phone' => $this->mother_phone,
                'mother_dop_phone' => $this->mother_dop_phone,
                'mother_activity' => $this->mother_activity,
                'mother_email' => $this->mother_email,
                'mother_telegram' => $this->mother_telegram,
                'mother_viber' => $this->mother_viber,
                'mother_notes' => $this->mother_notes,

                'father_surname' => $this->father_surname,
                'father_name' => $this->father_name,
                'father_middle_name' => $this->father_middle_name,
                'father_phone' => $this->father_phone,
                'father_dop_phone' => $this->father_dop_phone,
                'father_activity' => $this->father_activity,
                'father_email' => $this->father_email,
                'father_telegram' => $this->father_telegram,
                'father_viber' => $this->father_viber,
                'father_notes' => $this->father_notes,

                'other_relative_who' => $this->other_relative_who,
                'other_relative_surname' => $this->other_relative_surname,
                'other_relative_name' => $this->other_relative_name,
                'other_relative_middle_name' => $this->other_relative_middle_name,
                'other_relative_phone' => $this->other_relative_phone,
                'other_relative_dop_phone' => $this->other_relative_dop_phone,
                'other_relative_activity' => $this->other_relative_activity,
                'other_relative_email' => $this->other_relative_email,
                'other_relative_telegram' => $this->other_relative_telegram,
                'other_relative_viber' => $this->other_relative_viber,
                'other_relative_notes' => $this->other_relative_notes,
                'avatar' => $this->avatar,
                'old_id' => $this->old_id,
            ],
                'base_branch' => $this->base_branch->name,
                'manager' => $this->base_manager ?  $this->base_manager->surname . ' ' .$this->base_manager->name : 'Нет' ,
                'instructor' => $this->base_instructor ? $this->base_instructor->surname . ' ' .$this->base_instructor->name : 'Нет',
                'programm' => $this->programm ? $this->programm->name : 'Нет',
        ];
    }

    public function with($request)
    {
        return [
            'date' => date('D, d.m.Y H:i:s')
        ];
    }
}
