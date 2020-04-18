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
        return [
            'date' =>  Carbon::now()->format('d.m.Y'),
            'child_surname' =>  $this->child_surname,
            'child_name' =>  $this->child_name,
            'child_middle_name' =>  $this->child_middle_name,
            'parent_fio' =>  $this->child_surname . ' ' . $this->child_name . ' ' . $this->child_middle_name,
            'contract_name' =>  'Відкрий можливості',
            'town' =>  'м.Одесса',
            'branch_adress' =>  'м.Одеса, пр-т Добровольського, 122/2',
            'phone' =>  '+3 (067) 654 16 94',
            'ip' =>  'Булик І.В.',
            'programm_price' =>  '400',
            'programm_price_title' =>  'чотириста грн',
            'programm_price_stock' =>  '250',
            'programm_price_stock_title' =>  'двісті п’ятдесят',
            'programm_price_pledge' =>  '400',
            'programm_price_pledge_title' =>  'чотириста грн',
            'requisites' =>  'ЮЖНЕ ГРУ АТ КБ «Приватбанк», МФО 328704',
        ];
    }
}
