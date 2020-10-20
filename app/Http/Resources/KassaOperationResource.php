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
          "user"                => $this->kassaOperation->surname,
          "operation_type"      => $this->kassaOperationType->name,
          "coment"              => $this->coment,
          "sum"                 => $this->sum,
          "kassa"               => $this->branch->name,
          "operation"           => $this->payment == 1 ? 'Наличные' : 'Безнал',
        ];
    }
}
