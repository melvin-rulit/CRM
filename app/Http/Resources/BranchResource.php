<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductsInBranch;

class BranchResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
