<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class VmContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->mother_lpr) {
            $parent_surname = $this->mother_surname;
            $parent_name = $this->mother_name;
            $parent_middle_name = $this->mother_middle_name;
            $parent_phone = $this->mother_phone;
            $parent_viber = $this->mother_viber;
            $parent_email = $this->mother_email;
            $parent_facebook = $this->mother_facebook;
            $parent_instagram = $this->mother_instagram;
        }elseif($this->father_lpr){
            $parent_surname = $this->father_surname;
            $parent_name = $this->father_name;
            $parent_middle_name = $this->father_middle_name;
            $parent_phone = $this->father_phone;
            $parent_vider = $this->father_vider;
            $parent_email = $this->father_email;
            $parent_facebook = $this->father_facebook;
            $parent_instagram = $this->father_instagram;
        }elseif($this->other_relative_lpr){
            $parent_surname = $this->other_relative_surname;
            $parent_name = $this->other_relative_name;
            $parent_middle_name = $this->other_relative_middle_name;
            $parent_phone = $this->other_relative_phone;
            $parent_viber = $this->other_relative_viber;
            $parent_email = $this->other_relative_email;
            $parent_facebook = $this->other_relative_facebook;
            $parent_instagram = $this->other_relative_instagram;
        }



        return [
            'branch' => new BranchResource($this->base_branch),
            'date' =>  Carbon::now()->format('d.m.Y'),
            'start' =>  Carbon::now()->format('d.m.Y'),
            'child_surname' =>  $this->child_surname,
            'child_name' =>  $this->child_name,
            'child_middle_name' =>  $this->child_middle_name,
            'child_birthday' =>  $this->child_birthday,
            'parent_surname' =>  $parent_surname,
            'parent_name' =>  $parent_name,
            'parent_middle_name' =>  $parent_middle_name,
            'parent_phone' => $parent_phone,
            'parent_viber' => $parent_viber,
            'parent_email' => $parent_email,
            'parent_facebook' => $parent_facebook,
            'parent_instagram' => $parent_instagram,
            'contract_name' =>  'Відкрий можливості',
            'ip' =>  'Булик І.В.',
            'requisites' =>  'ЮЖНЕ ГРУ АТ КБ «Приватбанк», МФО 328704',
            'price' =>  '400',
            'price_title' =>  'чотириста',
            'price_stock' =>  '250',
            'price_stock_title' =>  'двісті п’ятдесят',
            'price_pledge' =>  '400',
            'price_pledge_title' =>  'чотириста',      
            'classes_total' =>  '10',      
            'classes_week' =>  '3',      
            'freezing_total' =>  '10',      
            'freezing_kolvo' =>  '3',     
        ];
    }
}
