<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractsResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contract;

class ContractController extends Controller
{
    public function getContract(Request $request){

        $contract = Contract::find($request['id']);
        return new ContractResource($contract);
    }

    public function getContracts(Request $request){

// ContractsResource::withoutWrapping();
        return new ContractsResource(Contract::where('base_id', '=', $request['id']));
    }
}
