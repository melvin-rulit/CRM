<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductsInBranch;

class BranchResource extends JsonResource
{
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            "id"                => $this->id,
            "name"              => $this->name,
            "adress"            => $this->adress,
            "phone"             => $this->phone,
            "geolocation"       => $this->geolocation,
            "region_id"         => $this->region_id,
            "requisites"        => $this->requisites,
            "organization"      => $this->organization,
            "currency"          => $this->currency,
            "products"          => ProductsInBranch::collection($this->products),
            "programms"         => $this->programms,
            "dopproducts"       => $this->dopproducts,
            "halls"             => $this->halls,
        ];
    }

}
