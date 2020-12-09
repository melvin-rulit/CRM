<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class KassaOperationResource extends JsonResource
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
          "id"                  => $this->id,
          "datetime"            => $this->created_at->format('d.m.Y/H:i'),
          "user"                => $this->kassaOperation->surname. ' ' . mb_substr($this->kassaOperation->name, 0, 1) . '.',
          "operation_type"      => $this->operation_type_id >= 1000000 ? $this->kassaOperationType->name : $this->kassaOperationTypeProduct->name,
          "coment"              => $this->coment,
          "sum"                 => $this->sum,
          "kassa"               => $this->branch->name,
          "branch"              => $this->branch->id,
          "source"              => $this->in_or_out == 1 ? 'Приход' : 'Расход',
          "operation"           => $this->payment == 1 ? 'Наличные' : 'Безнал',
        ];
    }
}
