<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractsResource;
use App\Http\Resources\ShowContractResource;
use App\Http\Controllers\Controller;
use App\Journal;
use App\Loger;
use App\Schedule_hall;
use App\Statuses;
use Illuminate\Http\Request;
use App\Base;
use App\Contract;
use App\Contract_pay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function getContract(Request $request){

        $contract = Contract::find($request['id']);
        return new ContractResource($contract);
    }

    public function showContract(Request $request){

        $contract = Contract::find($request['id']);
        return new ShowContractResource($contract->load('contract_pays'));
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
            if ($request['contract_type'] == 'main') {
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
            if ($request['contract_type'] == 'main') {
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
            if ($request['contract_type'] == 'main') {
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
    	$base->group_id = $request['group_id'];
    	$base->programm_id = $request['programm_id'];
    	$base->save();


	if ($request['contract_type'] == 'vm') {
    	$contract = new Contract;
		$contract->base_id = $request['base_id'];
		$contract->name = $request['name_vm'];
		$contract->price = $request['price'];
		$contract->start = Carbon::createFromDate($request['start']);
		$contract->end = Carbon::createFromDate($request['end']);
		$contract->end_actually = Carbon::createFromDate($request['end_actually']);
		$contract->date = Carbon::createFromDate($request['date']);
		$contract->active = true;
        $contract->contract_type = $request['contract_type'];
		$contract->save();

        //        ВЫНЕСТИ В ОТДЕЛЬНЫЙ МЕТОД =========================================================================

        Statuses::where('base_id', $request['base_id'])->update(
            [
                'status_id' => 5,
                'steps_id' => 3,
//                'call_date' => Carbon::createFromDate($request->year, $request->month, $request->day)->addDays(-1)
            ]
        );

        // И добавляем комментарий
        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '4',
                'base_id' => $request['base_id'],
                'level_name' => 'success',
                'message' => 'Присвоен статус Покупка ВМ')
        );

        //        ВЫНЕСТИ В ОТДЕЛЬНЫЙ МЕТОД =========================================================================

        $now = Carbon::now();
        $week = $now->weekday();

        $schedule = Schedule_hall::where('group_id', $request['group_id'])->get();



        foreach($schedule as $value){

            // Если сегодняшний день
            if($value->day === $week){

                $now = Carbon::now();

                $journal = Journal::create(
                    [
                        'base_id' => $request['base_id'],
                        'day' => $now->format('d'),
                        'month' => $now->format('m'),
                        'year' => $now->format('Y'),
                        'icon' => 'fe fe-alert-circle text-warning',
                        'type' => 4,
                    ]
                );
            }

            // Если день недели больше чем текущий
            if($value->day > $week){

                $now = Carbon::now();

                $journal = Journal::create(
                    [
                        'base_id' => $request['base_id'],
                        'day' => $now->addDays($value->day - $week)->format('d'),
                        'month' => $now->addDays($value->day - $week)->format('m'),
                        'year' => $now->addDays($value->day - $week)->format('Y'),
                        'icon' => 'fe fe-alert-circle text-warning',
                        'type' => 4,
                    ]
                );
            }


            // Если день недели меньше чем текущий
            if($value->day < $week){

                $itog = 7 - ($week - $value->day);

                $now = Carbon::now();


                $journal = Journal::create(
                    [
                        'base_id' => $request['base_id'],
                        'day' => $now->addDays($itog)->format('d'),
                        'month' => $now->addDays($itog)->format('m'),
                        'year' => $now->addDays($itog)->format('Y'),
                        'icon' => 'fe fe-alert-circle text-warning',
                        'type' => 4,
                    ]
                );
            }

        }


	}

	if ($request['contract_type'] == 'main') {
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
		$contract->start = Carbon::createFromDate($request['start']);
		$contract->end = Carbon::createFromDate($request['end']);
		$contract->end_actually = Carbon::createFromDate($request['end_actually']);
		$contract->date = Carbon::createFromDate($request['date']);
		$contract->active = true;
		$contract->form_size = $request['form_size'];
        $contract->classes_total =  $request['classes_total'];
        $contract->classes_week =  $request['classes_week'];
        $contract->freezing_total =  $request['freezing_total'];
        $contract->freezing_kolvo = $request['freezing_kolvo'];
        $contract->programm = $request['programm'];
        $contract->currency = $request['currency'];
        $contract->adress = $request['adress'];
        $contract->price_title = $request['price_title'];
        $contract->category_time = $request['category_time'];
        $contract->contract_type = $request['contract_type'];
		$contract->save();


        // Записываем массив с оплатами у контракта
        foreach ($request->pays as $key => $value) {
            $contract_pays = new Contract_pay;
            $contract_pays->contract_id = $contract->id;
            $contract_pays->pay = $value['pay'];
            $contract_pays->day = $value['day'] ? $value['day'] : 0;
            $contract_pays->date = $value['day'] ? Carbon::createFromDate($request['start'])->addDays($value['day'])->format('Y-m-d') : $request['start'];
            $contract_pays->save();
        }


        Statuses::where('base_id', $request['base_id'])->update(
            [
                'status_id' => 9,
                'steps_id' => 4,
            ]
        );

        // И добавляем комментарий
        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '4',
                'base_id' => $request['base_id'],
                'level_name' => 'success',
                'message' => 'Присвоен статус Занимается')
        );


	}

    	return [
    		'success' => "ok",
    	];
    }
}
