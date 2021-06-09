<?php

namespace App\Http\Controllers\Api\V2;

use App\Branch;
use App\Http\Resources\BaseAllResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractsResource;
use App\Http\Resources\ShowContractResource;
use App\Http\Resources\GatesResource;
use App\Http\Controllers\Controller;
use App\Journal;
use App\User;
use Gate;
use App\KassaOperation;
use App\KassaOperationType;
use App\Loger;
use App\Schedule_hall;
use App\Statuses;
use Illuminate\Http\Request;
use App\Base;
use App\Contract;
use App\Contract_pay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{


    public function editContract(Request $request){

        Contract::where('id', $request->id)->update(
            [
                $request['field_name'] => $request['field_value'],
            ]
        );
    }

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
        $contract->balance = $request['balance'];
		$contract->start = Carbon::createFromDate($request['start']);
		$contract->end = Carbon::createFromDate($request['end']);
		$contract->end_actually = Carbon::createFromDate($request['end_actually']);
		$contract->date = Carbon::createFromDate($request['date']);
		$contract->active = true;
        $contract->contract_type = $request['contract_type'];
		$contract->save();

		// Может быть временным решением, если есть оплата из контракта ВМ то мы создаем этот платеж в кассе
        // Если ввели часть оплаты то продолжаем
        if ($request['pay']){
            $this->saveOperation($request['base_id'], $request['name_vm'], $request['pay']);
        }

        // И добавляем оплату по контракту
        $contract_pay = Contract_pay::create(
            [
                'contract_id' => $contract->id,
                'pay' => $request->balance,
                'day' => 0,
                'date' => $request['start'],
            ]
        );



        $this->saveOperation($request['base_id'], $request['name_vm'], $request['price']);

        //        ВЫНЕСТИ В ОТДЕЛЬНЫЙ МЕТОД =========================================================================

        Statuses::where('base_id', $request['base_id'])->update(
            [
                'status_id' => 5,
                'steps_id' => 3,
//                'call_date' => Carbon::createFromDate($request->year, $request->month, $request->day)->addDays(-1)
            ]
        );

        // И добавляем комментарий
        loger(4, $request->base_id, null,null,'Присвоен статус Покупка ВМ');

        //        ВЫНЕСТИ В ОТДЕЛЬНЫЙ МЕТОД =========================================================================

        $now = Carbon::now();
        $week = $now->weekday(); // День в недели
        $weekOfYear = $now->weekOfYear; // Неделя в году

        $date = new Carbon($request['week']);
        $week = $date->weekOfYear;

        $dateNew = $date->setISODate($date->year , $week);

        $schedule = Schedule_hall::where('group_id', $request['group_id'])->get();


        foreach($schedule as $value){

            if($week > $weekOfYear){
                $journal = Journal::create(
                    [
                        'base_id' => $request['base_id'],
                        'day' => $date->addDays($value->day - 1)->day,
                        'month' => $date->month,
                        'year' => $date->year,
                        'icon' => 'fe fe-alert-circle text-warning',
                        'type' => 4,
                    ]
                );
            }

            // Если сегодняшний день и неделя текущая
            if($value->day === $week && $weekOfYear == $week){

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

            // Если день недели больше чем текущий и неделя текущая
            if($value->day > $week && $weekOfYear == $week){

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


            // Если день недели меньше чем текущий и неделя текущая
            if($value->day < $week && $weekOfYear == $week){

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

        $this->updateContractDate($contract->id, $request['base_id']);

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
		$contract->balance = $request['balance'];
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

        loger(4, $request->base_id,null, null, 'Присвоен статус Занимается');

        $this->saveOperation($request['base_id'], $request['name'], $request->pays[0]['pay']);

	}

    	return [
    		'success' => "Контракт создан и записан в БД",
    	];
    }

    public function saveOperation($id, $name, $pay){

        $base = Base::find($id);

        // Добавляем вид операции
        $kassa_operation = KassaOperationType::create(
            [
                'name' => "Платеж контракт " . $name . " 1 " . $base->child_surname . ' ' . mb_substr($base->child_name, 0, 1) . '.' . mb_substr($base->child_middle_name, 0, 1),
                'branch_id' => $base->branch,
                'coming' => true,
                'cash' => true,
            ]
        );

        // Добавляем операцию в кассу
        $kassa_operation = KassaOperation::create(
            [
                'branch_id' => $base->branch,
                'user_id' => Auth::id(),
                'coming' => true,
                'cash' => true,
                'operation_type_id' => $kassa_operation->id,
                'payment' => true,
                'in_or_out' => true,
                'sum' => $pay,
            ]
        );

        // Добавить внесение в кассу
        $sum = Branch::where('id', $base->branch)->value('sum');

        Branch::where('id', $base->branch)->update(
            [
                'sum' => $sum + $pay,
            ]
        );
    }

    public function updateContractDate($contract_id, $base_id){

        // Тут может потребоваться проверить условие на дату, так как $journal может вернуть дофига старых записей

        $journal = Journal::where('base_id', $base_id)
            ->where('type', 4)
            ->get();

        Contract::where('id', $contract_id)->update(
            [
                'start' => Carbon::createFromDate($journal->first()->year, $journal->first()->month,$journal->first()->day)->format('Y-m-d'),
                'end'   => Carbon::createFromDate($journal->last()->year, $journal->last()->month,$journal->last()->day)->format('Y-m-d'),
            ]
        );
    }


    public function test(Request $request){

        $user = User::find(Auth::user()->id);

        $collection = collect();

        foreach ($user->branches as $branch) {
            foreach ($branch->bases as $base) {
                $collection->push($base);
            }
        }

        // Исправить костыль с фильтром

        $users = Base::filter($request->all())->get();

        $collectionA = $users->keyBy('id');

        $collectionB = $collection->keyBy('id');

        $collection = $collectionA->intersectByKeys($collectionB);

        return BaseAllResource::collection($collection);

//        return User::filter($request->all())->get();

//        $filteredData = [];
//        $arr = [];
//        $users = DB::select('select * from contract_pays where id between 80 and 200');
//
//
//        for ($i = 10; $i <= 29; $i++) {
//
//
//            $getfilteredData = function ($arr, $datadoc) {
//                return array_filter($arr, function ($item) use ($datadoc) {
//                    return strpos($item->created_at, $datadoc) !== false;
//                });
//            };
//
//            $newArr = [
//                "date" =>'2020-07-'. $i,
//                "retail" => array_sum(array_column($getfilteredData($users, '2020-07-'. $i), 'pay')),
//                "bn" => array_sum(array_column($getfilteredData($users, '2020-07-'. $i), 'pay')),
//            ];
//
//            array_push($arr, $newArr);
//
//        }
//
//        return $arr;







//        $journal = Journal::where('base_id', 91)
//            ->get();
//
//        return GateResource::collection($journal);

//        $this->updateContractDate(119, 35);


//        $journal = Journal::where('base_id', 102)
//            ->where('type', 4)
//            ->get();

//        $journal->first();

//        return $journal;


//        $date = new Carbon('2021-01-20');
//        $week = $date->weekOfYear;
//        $date->setISODate($date->year , $week);
//
//        $schedule = Schedule_hall::where('group_id', 76)->get();
//
//
//        foreach($schedule as $value) {
//
//            $journal = Journal::create(
//                [
//                    'base_id' => 89,
//                    'day' => $date->addDays($value->day - 1)->day,
//                    'month' => $date->month,
//                    'year' => $date->year,
//                    'icon' => 'fe fe-alert-circle text-warning',
//                    'type' => 4,
//                ]
//            );
//        }



    }
}
