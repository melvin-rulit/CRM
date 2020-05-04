<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractsResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Base;
use App\Contract;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function getContract(Request $request){

        $contract = Contract::find($request['id']);
        return new ContractResource($contract);
    }

    public function getContracts(Request $request){

        return new ContractsResource(Contract::where('base_id', '=', $request['id']));
    }

    public function saveContractAndEditBaseFields(Request $request){

    	$base = Base::find($request['base_id']);

        if ($base->mother_lpr) {
            $base->mother_surname = $request['parent_surname'];
            $base->mother_name = $request['parent_name'];
            $base->mother_middle_name = $request['parent_middle_name'];
            if ($request['contract_type'] == 'osn') {
	          	$base->mother_phone = $request['parent_phone'];
	            $base->mother_viber = $request['parent_viber'];
	            $base->mother_email = $request['parent_email'];
	            $base->mother_facebook = $request['parent_facebook'];
	            $base->mother_instagram = $request['parent_instagram'];
            }
        }elseif($base->father_lpr){
            $base->father_surname = $request['parent_surname'];
            $base->father_name = $request['parent_name'];
            $base->father_middle_name = $request['parent_middle_name'];
            if ($request['contract_type'] == 'osn') {
	            $base->father_phone = $request['parent_phone'];
	            $base->father_viber = $request['parent_viber'];
	            $base->father_email = $request['parent_email'];
	            $base->father_facebook = $request['parent_facebook'];
	            $base->father_instagram = $request['parent_instagram'];
        }
        }elseif($base->other_relative_lpr){
            $base->other_relative_surname = $request['parent_surname'];
            $base->other_relative_name = $request['parent_name'];
            $base->other_relative_middle_name = $request['parent_middle_name'];
            if ($request['contract_type'] == 'osn') {
	            $base->other_relative_phone = $request['parent_phone'];
	            $base->other_relative_viber = $request['parent_viber'];
	            $base->other_relative_email = $request['parent_email'];
	            $base->other_relative_facebook = $request['parent_facebook'];
	            $base->other_relative_instagram = $request['parent_instagram'];
        }
        }

    	$base->child_surname = $request['child_surname'];
    	$base->child_name = $request['child_name'];
    	$base->child_middle_name = $request['child_middle_name'];
    	$base->child_birthday = $request['child_birthday'];
    	$base->save();


	if ($request['contract_type'] == 'vm') {
    	$contract = new Contract;
		$contract->base_id = $request['base_id'];
		$contract->name = $request['name_vm'];
		$contract->price = $request['price'];
		$contract->start = $request['start'];
		$contract->end = $request['end'];
		$contract->end_actually = $request['end_actually'];
		$contract->date = Carbon::now()->format('d.m.Y');
		$contract->active = true;
		$contract->save();
	}

	if ($request['contract_type'] == 'osn') {
    	$contract = new Contract;
		$contract->base_id = $request['base_id'];
        $contract->child_surname = $request['child_surname'];
        $contract->child_name = $request['child_name'];
        $contract->child_middle_name = $request['child_middle_name'];
        $contract->child_birthday = $request['child_birthday'];
        $contract->parent_surname = $request['parent_surname'];
        $contract->parent_name = $request['parent_name'];
        $contract->parent_middle_name = $request['parent_middle_name'];
        $contract->parent_phone = $request['parent_phone'];
        $contract->parent_viber = $request['parent_viber'];
        $contract->parent_email = $request['parent_email'];
        $contract->parent_facebook = $request['parent_facebook'];
        $contract->parent_instagram = $request['parent_instagram'];
		$contract->name = $request['name'];
		$contract->price = $request['price'];
		$contract->start = $request['start'];
		$contract->end = $request['end'];
		$contract->end_actually = $request['end_actually'];
		$contract->date = Carbon::now()->format('d.m.Y');
		$contract->active = true;
		$contract->form_size = $request['form_size'];
        $contract->classes_total =  $request['classes_total'];      
        $contract->classes_week =  $request['classes_week'];      
        $contract->freezing_total =  $request['freezing_total'];      
        $contract->freezing_kolvo = $request['freezing_kolvo'];    
		$contract->save();
	} 

    	return [
    		'success' => "ok",
    	];
    }
}
