<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\BranchesResource;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\UsersResource;
use App\Http\Resources\BaseAllResource;
use App\Http\Resources\VmContractResource;
use App\Http\Resources\TestResource;
use App\Http\Resources\AddChildrenGroupResource;
use App\Http\Resources\GetUserInGroupResource;
use App\Http\Resources\HallResource;
use App\Http\Resources\Schedule_hallResource;
use App\Http\Controllers\Controller;
use App\Statuses;
use Illuminate\Http\Request;
use App\Filters\UsersFilter;
use App\Base;
use App\Programm;
use App\Branch;
use App\User;
use App\Role;
use App\Journal;
use App\Loger;
use App\Comments;
use App\Hall;
use App\Group;
use App\Schedule_hall;
use App\Contract_pay;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;


class BaseController extends Controller
{

    public function deleteSchedule(Request $request)
    {

        Schedule_hall::where('hall_id', $request->hall_id)->where('day', $request->day)->where('time', $request->time)->delete();

        $schedule_hall = Schedule_hall::where('hall_id', $request->hall_id)->where('day', $request->day)->get();

        return Schedule_hallResource::collection($schedule_hall);
    }

    public function getGroupInHall(Request $request)
    {
        return Group::where('hall_id', $request->hall_id)->get();

    }

    public function saveSchedule(Request $request)
    {
        Schedule_hall::create($request->all());

        $schedule_hall = Schedule_hall::where('hall_id', $request->hall_id)->where('day', $request->day)->get();

        return Schedule_hallResource::collection($schedule_hall);
    }

    public function Schedule(Request $request)
    {
        $schedule_hall = Schedule_hall::where('hall_id', $request->hall_id)->where('day', $request->day)->get();

        return Schedule_hallResource::collection($schedule_hall);
    }

    public function showHall(Request $request)
    {
        $hall = Hall::find($request->hall_id)->load(['schedule_hall' => function ($query) use ($request){
            $query->with('group')->where('day', $request->day);
        }]);

        return new HallResource($hall);
    }


    public function showHProgramms(Request $request)
    {
        return Programm::where('branch_id', $request->branch_id)->get();

    }


    public function getTest(Request $request){
        $base = Base::where('branch', '=', $request->id)->get();

        return AddChildrenGroupResource::collection($base);
    }

    public function saveTest(Request $request){

        $base = Base::find($request->id);
        $base->group_id = $request->group_id;
        $base->save();
    }

    public function updateTest(Request $request){

        $journal = Journal::create($request->all());
    }


    public function getUserInGroup(Request $request){

        // $base = Base::where('group_id', $request->group_id)->get();


        $base = Base::with(['journal' => function($query) use ($request){
            $query->where('year', $request->year);
            $query->where('month', $request->month);
        }])->where('group_id', $request->group_id)->get();


        if ($base->count() > 0) {
            return GetUserInGroupResource::collection($base);
        }else{
            return 'error';
        }
    }

    // Метод возвращает группы доступные для редактирование у зала
    public function getEditingGroup(Request $request){

        return Group::where('hall_id', $request->hall_id)->get();

    }



    public function workout(Request $request){

        // Если на эту дату тренировка уже проставлена то нужно решить что дальше делать
        $base = Base::find($request->base_id);


        // Выбираем только активные контракты и с типом основной контракт
        $contracts = $base->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()->where('contract_type', 'main');

        // Выбираем только активные контракты и с типом ВМ
        $contractsVM = $base->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()->where('contract_type', 'vm');

        if ($contracts->count() == 1 || $contractsVM->count() == 1) {

            $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->where('month', $request->month)->get();

            // Если уже стоит тренировка то выдаем ошибку
            if ($journal[0]->type == 1) {
                return [
                    'response'  => "Уже стоит тренировка, выберите другой статус",
                ];
            }

            // Если стоит пропусщеная тренировка то выдаем ошибку
            if($journal[0]->type == 3){
                return [
                    'response'  => "Клиент пропустил занятие",
                ];
            }


            // Если на текущей ячейки не стоит пропущенная тренировка и количество тренировок в контракте больше нуля то списываем одну тренировку
            if ($journal[0]->type !== 3 && $contracts->count()) {
                if($contracts[0]->classes_total > 0){
                    $base->contracts()->where('contract_type', 'main')->decrement('classes_total');
                }
            }


            // Проверяем состоит ли клиент в группе с программой ПК
            $group = Base::find($request->base_id)->group->programm;

            if($group->pk && $journal[0]->type == 4){
                // В агрегаторе лидов изменяем статус и этап, дату звонка ставим за день до назначеной тренировки
                Statuses::where('base_id', $request->base_id)->update(
                    [
                        'status_id' => 4,
                        'steps_id' => 2,
                    ]
                );

                // Добавляем в лог запись
                Loger::create(array(
                        'user_id' => Auth::id(),
                        'channel' => '4',
                        'base_id' => $request->base_id,
                        'level_name' => 'success',
                        'message' => 'Присвоен статус Явка ПК')
                );
            }

            // Если группа ВМ, стоит тренировка и статус Покупка ВМ
            if($group->vm && $journal[0]->type == 4 && $base->statuses->status_id == 5){
                // В агрегаторе лидов изменяем статус и этап на Явка ВМ 1

                // Чтоб узнать дату следующего звонка нужно выяснить есть ли после этой еще трнеировки
                $jour = Journal::where('base_id', $request->base_id)
                    ->where('type', 4)
                    ->orderBy('id', 'desc')
                    ->first();

                Statuses::where('base_id', $request->base_id)->update(
                    [
                        'status_id' => 6,
                        'steps_id' => 3,
                        'call_date' => $jour ? Carbon::createFromDate($jour->year, $jour->month, $jour->day)->addDays(-1) : $jour->call_date,
                    ]
                );

                // Добавляем в лог запись
                Loger::create(array(
                        'user_id' => Auth::id(),
                        'channel' => '4',
                        'base_id' => $request->base_id,
                        'level_name' => 'success',
                        'message' => 'Присвоен статус Явка ВМ 1')
                );
            }

            // Если группа ВМ, стоит тренировка и статус Явка ВМ 1
            if($group->vm && $journal[0]->type == 4 && $base->statuses->status_id == 6){
                // В агрегаторе лидов изменяем статус и этап на Явка ВМ 2

                // Чтоб узнать дату следующего звонка нужно выяснить есть ли после этой еще трнеировки
                $jour = Journal::where('base_id', $request->base_id)
                    ->where('type', 4)
                    ->orderBy('id', 'desc')
                    ->first();

                Statuses::where('base_id', $request->base_id)->update(
                    [
                        'status_id' => 7,
                        'steps_id' => 3,
                        'call_date' => $jour ? Carbon::createFromDate($jour->year, $jour->month, $jour->day)->addDays(-1) : $jour->call_date,
                    ]
                );

                // Добавляем в лог запись
                Loger::create(array(
                        'user_id' => Auth::id(),
                        'channel' => '4',
                        'base_id' => $request->base_id,
                        'level_name' => 'success',
                        'message' => 'Присвоен статус Явка ВМ 2')
                );

            }

            // Если группа ВМ, стоит тренировка и статус Явка ВМ 2
            if($group->vm && $journal[0]->type == 4 && $base->statuses->status_id == 7){
                // В агрегаторе лидов изменяем статус и этап на Явка ВМ 3

                // Чтоб узнать дату следующего звонка нужно выяснить есть ли после этой еще трнеировки
                $jour = Journal::where('base_id', $request->base_id)
                    ->where('type', 4)
                    ->orderBy('id', 'desc')
                    ->first();

                Statuses::where('base_id', $request->base_id)->update(
                    [
                        'status_id' => 8,
                        'steps_id' => 3,
                        'call_date' => $jour ? Carbon::createFromDate($jour->year, $jour->month, $jour->day)->addDays(-1) : $jour->call_date,
                    ]
                );

                // Добавляем в лог запись
                Loger::create(array(
                        'user_id' => Auth::id(),
                        'channel' => '4',
                        'base_id' => $request->base_id,
                        'level_name' => 'success',
                        'message' => 'Присвоен статус Явка ВМ 3')
                );
            }



            // Если есть запись то обнавляем иконку и данные, если нет то создаем новую
            $journal = Journal::updateOrCreate(
                ['base_id' => $request->base_id, 'year' => $request->year, 'month' => $request->month, 'day' => $request->day],
                [
                    'base_id' => $request->base_id,
                    'day' => $request->day,
                    'month' => $request->month,
                    'year' => $request->year,
                    'icon' => 'fe fe-check text-success',
                    'type' => 1
                ]
            );


            return [
                'response'  => "success",
            ];
            // Если и так уже стоит значение, то ничего не делать
        }

        if ($contracts->count() == 0) {
            return [
                'response'  => "У данного клиента закончился контракт - посещение занятий приостановлено",
            ];
        }

        if ($contracts->count() > 1) {
            return [
                'response'  => "У клиента больше одного активного контракта, обратитесь к администратору",
            ];
        }

    }

    public function notVisit(Request $request){


        $base = Base::find($request->base_id);

        // Выбираем только активные контракты и с типом основной контракт
        $contracts = $base->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()->where('contract_type', 'main');

        if ($contracts->count() == 1) {

            // Проверяем стоит ли сейчас посещенная тренировка на текущей ячейки
            $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->where('type', 1)->get();

            // Если записи нет то списываем одну тренировку
            if ($journal->isEmpty()) {
                $base->contracts()->where('contract_type', 'main')->decrement('classes_total');
            }

            // Если есть запись то обнавляем иконку и данные, если нет то создаем новую
            $journal = Journal::updateOrCreate(
                ['base_id' => $request->base_id, 'year' => $request->year, 'month' => $request->month, 'day' => $request->day],
                [
                    'base_id'   => $request->base_id,
                    'day'       => $request->day,
                    'month'     => $request->month,
                    'year'      => $request->year,
                    'icon'      => 'fe fe-x text-danger',
                    'type'      => 3,
                ]
            );

            // И добавляем комментарий
            Loger::create(array(
                    'user_id' => Auth::id(),
                    'channel' => '5',
                    'base_id' => $request->base_id,
                    'level_name' => 'success',
                    'message' => $request->comment)
            );

            return [
                'response'  => "success",
            ];
        }

        if ($contracts->count() == 0) {
            return [
                'response'  => "У данного клиента закончился контракт - посещение занятий приостановлено",
            ];
        }

        if ($contracts->count() > 1) {
            return [
                'response'  => "У клиента больше одного активного контракта, обратитесь к администратору",
            ];
        }

    }

    public function newWorkout(Request $request){

        // Проверяем стоит ли на текущей ячейки какие нибудь данные
        $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->get();

        // Проверяем в какой группе состоит клиент (ВМ или ПК)
        $group = Base::find($request->base_id)->group->programm;



        // Если записи нет то спросто назначаем тренировку
        if ($journal->isEmpty()) {
            $journal = Journal::create(
                [
                    'base_id' => $request->base_id,
                    'day' => $request->day,
                    'month' => $request->month,
                    'year' => $request->year,
                    'icon' => 'fe fe-alert-circle text-warning',
                    'type' => 4,
                ]
            );

            if($group->pk){
                // В агрегаторе лидов изменяем статус и этап, дату звонка ставим за день до назначеной тренировки
                Statuses::where('base_id', $request->base_id)->update(
                    [
                        'status_id' => 3,
                        'steps_id' => 2,
                        'call_date' => Carbon::createFromDate($request->year, $request->month, $request->day)->addDays(-1)
                    ]
                );
                // Добавляем в лог запись
                Loger::create(array(
                        'user_id' => Auth::id(),
                        'channel' => '4',
                        'base_id' => $request->base_id,
                        'level_name' => 'success',
                        'message' => 'Присвоен статус Запись ПК')
                );
            }

            if($group->vm){
                // В агрегаторе лидов изменяем статус и этап, дату звонка ставим за день до назначеной тренировки
                Statuses::where('base_id', $request->base_id)->update(
                    [
                        'status_id' => 5,
                        'steps_id' => 3,
                        'call_date' => Carbon::createFromDate($request->year, $request->month, $request->day)->addDays(-1)
                    ]
                );
                // Добавляем в лог запись
                Loger::create(array(
                        'user_id' => Auth::id(),
                        'channel' => '4',
                        'base_id' => $request->base_id,
                        'level_name' => 'success',
                        'message' => 'Присвоен статус Покупка ВМ')
                );
            }

            return "success";
        }

    }

    public function freezing(Request $request){

        // Если на эту дату тренировка уже проставлена то нужно решить что дальше делать
        $base = Base::find($request->base_id);

        // Выбираем только активные контракты и с типом основной контракт
        $contracts = $base->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()->where('contract_type', 'main');

        // Если найден один активный контракт
        if ($contracts->count() == 1) {

            // Проверяем стоит ли сейчас посещенная тренировка на текущей ячейки
            $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->where('type', 1)->get();

            // Если есть запись посещенной тренировки, то останавливаем
            if (!$journal->isEmpty()) {
                return [
                    'response'  => "Клиент посетил тренировку, поставить заморозку не возможно",
                ];
            }

            // Проверяем стоит ли сейчас новая тренировка на текущей ячейки
            $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->where('type', 4)->get();

            // Если есть запись новой тренировки, то останавливаем
            if (!$journal->isEmpty()) {
                return [
                    'response'  => "Нельзя поставить заморозку этому клиенту",
                ];
            }

            $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->where('type', 2)->get();

            // Если уже стоит этот статус то выдаем оштбку
            if (!$journal->isEmpty()) {
                return [
                    'response'  => "Уже стоит заморозка, выберите другой статус",
                ];
            }

            // Проверяем остались ли заморозки, если да то уменьшаем на еденицу, если нет возвращаем сообщение с ошибкой
            if ($contracts->first()->freezing_total == 0) {
                return [
                    'response'  => "У клиента закончились заморозки",
                ];
            }else{
                $contracts[0]->decrement('freezing_total');

                // Смещаем дату фактического окончания контракта
                // 1 заморозка прибавляем к дате окончания контракта 3 дня
                // 2 заморозки прибавляем к дате окончания контракта 7 дней
                // 3 заморозки прибавляем к дате окончания контракта 10 дней

                switch ($contracts->first()->freezing_kolvo) {
                    case 1:
                        $contracts->first()->end_actually = Carbon::createFromDate($contracts[0]->end_actually)->addDays(3);
                        $contracts->first()->save();
                        break;
                    case 2:
                        $contracts->first()->end_actually = Carbon::createFromDate($contracts[0]->end_actually)->addDays(7);
                        $contracts->first()->save();
                        break;
                    case 3:
                        $contracts->first()->end_actually = Carbon::createFromDate($contracts[0]->end_actually)->addDays(10);
                        $contracts->first()->save();
                        break;
                }

                // Записываем в журнал как заморозку
                Journal::updateOrCreate(
                    ['base_id' => $request->base_id, 'year' => $request->year, 'month' => $request->month, 'day' => $request->day],
                    [
                        'base_id'   => $request->base_id,
                        'day'       => $request->day,
                        'month'     => $request->month,
                        'year'      => $request->year,
                        'icon'      => 'fe fe-sun text-primary',
                        'type'      => 2,
                    ]
                );
            }

            return [
                'response'  => "success",
            ];

        }
        if ($contracts->count() == 0) {
            return [
                'response'  => "У данного клиента закончился контракт - посещение занятий приостановлено",
            ];
        }

        if ($contracts->count() > 1) {
            return [
                'response'  => "У клиента больше одного активного контракта, обратитесь к администратору",
            ];
        }
    }

    public function addNewComent(Request $request){

        // Добавляем комментарий
        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '5',
                'base_id' => $request->base_id,
                'level_name' => 'success',
                'message' => $request->comment)
        );
    }


    public function uploadDocument(Request $request){

        $path = $request['file']->store('public/files');
        $path = str_replace("public","storage", $path);

        $document = Document::create([
            'base_id'   => $request->base_id,
            'name'   => $request->name,
            '$path'   => $path,
        ]);
    }


    public function showHistory(Request $request){

        $comments = Loger::where('base_id', $request->base_id)->get();

        return CommentsResource::collection($comments);
    }
















    public function test(Request $request){


        $user = User::find(Auth::user()->id);

        $collection = collect();

        foreach ($user->branches as $branch) {
            foreach ($branch->bases as $base) {
                $collection->push($base);
            }
        }

        return BaseAllResource::collection($collection->all());
    }

    public function index(){

        $user = User::find(Auth::user()->id);

        $collection = collect();

        foreach ($user->branches as $branch) {
            foreach ($branch->bases as $base) {
                $collection->push($base);
            }
        }

        return BaseAllResource::collection($collection->all());
    }

    public function addNewUser(Request $request){

        // Добавляем нового клиента
        $base = Base::create($request->all());

        // Добавляем в агрегатор лидов
        $statuses = new Statuses;
        $statuses->base_id = $base->id;
        $statuses->steps_id = 1;
        $statuses->status_id = 1;
        $statuses->call_date = Carbon::now();
        $statuses->save();

        // Добавляем в лог информацию что клиент создан
        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '2',
                'base_id' => $base->id,
                'level_name' => 'success',
                'message' => 'Добавил клиента в базу')
        );

        // Добавляем в лог информацию что клиенту присвоен статус
        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '4',
                'base_id' => $base->id,
                'level_name' => 'success',
                'message' => 'Присвоен статус Новый')
        );


        return $base->id;
    }

    public function getInfo(Request $request){

        $base = Base::find($request->id);

        // Если в карточке кто нибудь работает - возвращаем соответствующий response, иначе блокируем
        if ($base->block){
            return [
                'response'          => "block",
                'user_block_name'   => $base->user_block_name->surname .' '. $base->user_block_name->name,
            ];
        }else{
            $base->block = 1;
            $base->user_block_id = Auth::user()->id;
            $base->save();
        }

        // Меняем на статус В работе если он Новый
        $statuses = Statuses::where('base_id', $request->id)->where('status_id', 1)->get();

        if (!$statuses->isEmpty()) {

            $statuses = Statuses::where('base_id', $request->id)->update(['status_id' => 2]);



            // Добавляем в лог запись
            Loger::create(array(
                    'user_id' => Auth::id(),
                    'channel' => '4',
                    'base_id' => $base->id,
                    'level_name' => 'success',
                    'message' => 'Присвоен статус В работе')
            );

        }

        return new ArticleResource($base);
    }

    public function getVmContract(Request $request){

        $base = Base::find($request->id);

        return new VmContractResource($base->load(['base_branch']));
    }

    public function getBranches(){

        $user = User::find(Auth::user()->id);

        return new BranchesResource($user);
    }

    public function getManagers(){

        $roles = Role::where('title', 'like' , "%менеджер%")->get();

        $collection = collect();

        foreach ($roles as $role) {
            foreach ($role->rolesUsers as $value) {
                $collection->push($value);
            }
        }

        return new UsersResource($collection);
    }

    public function getInstructors(){

        $roles = Role::where('title', 'like' , "%тренер%")->get();

        $collection = collect();

        foreach ($roles as $role) {
            foreach ($role->rolesUsers as $value) {
                $collection->push($value);
            }
        }

        return new UsersResource($collection);
    }

    public function getProgramms(Request $request){

        $base = Base::find($request->id)->base_branch->programms;

        return new UsersResource($base);
    }

    public function getUsers(){

        return new UsersResource(User::select('id', 'name', 'surname')->get());
    }

    public function upload(Request $request){

        $path = $request['file']->store('public/avatars');
        $path = str_replace("public","storage", $path);

        $base = Base::find($request['id']);
        $base->avatar = $path;
        $base->save();

        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '2',
                'level_name' => 'success',
                'message' => 'изменил аватар '.$base->id)
        );

        return $path;
    }

    public function filter(Request $request, UsersFilter $filters)
    {

        $user = User::find(Auth::user()->id);

        $collection = collect();

        foreach ($user->branches as $branch) {
            foreach ($branch->bases as $base) {
                $collection->push($base);
            }
        }

        // Исправить костыль с фильтром

        $users = Base::filter($filters)->get();

        $collectionA = $users->keyBy('id');

        $collectionB = $collection->keyBy('id');

        $collection = $collectionA->intersectByKeys($collectionB);

        if ($request->expectsJson()) {
            return BaseAllResource::collection($collection);
        }

        return view('pages.product', compact('users'));
    }

//    Обновляем ЛПР родителя
    public function updateLpr(Request $request){
//        Очищаем список всех ЛПР
        Base::where('id', $request->id)->update(array('mother_lpr' => '0', 'father_lpr' => '0', 'other_relative_lpr' => '0'));

        $curent_lpr = $request->lpr;
        $base = Base::find($request->id);
        $base->$curent_lpr = 1;
        $base->save();

        return [
            'success' => 'ok'
        ];
    }

    public function addClientFromPromoter(Request $request){

        return 'Promoter';
    }

    // Снимаем блокировку с карточки
    public function removeBlock(Request $request){

        Base::where('id', $request->id)->update(['block' => 0, 'user_block_id' => 0]);

    }

    public function getTest2(){

//        $user = User::find(Auth::user()->id);
//
//        $collection = collect();
//        $collection_itog = collect();
//
//        foreach ($user->branches as $branch) {
//            foreach ($branch->bases as $base) {
//                $collection->push($base);
//            }
//        }


//        foreach ($collection as $value){
//            if ($value->manager === Auth::user()->id){
//                $collection_itog->push($value);
//            }
//        }

        $base = Base::find(50);


        foreach ($base->contracts as $value){
            return $value->contract_pays;
        }

//        return $collection_itog->count();


        // Звонки клиентам дата платежа у которых наступает за 1 день
        // Получаем дату -1 день до окончания оплаты в контракте
//        $date = Carbon::today()->addDays(-1)->toDateString();
//
//        $pay = Contract_pay::with('contract')->where('date', '=', $date)->get();
//
//
//        $collection = collect();
//
//
//        // Перебираем массив и если у клиента привязан менеджер то добавляем в коллекцию
//        foreach ($pay as $value) {
//            if($value->contract->user->manager) {
//                $collection->push($value->contract->user);
//            }
//        }
//
//        return $collection;

    }


}
