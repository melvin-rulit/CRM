<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\BranchesResource;
use App\Http\Resources\UsersResource;
use App\Http\Resources\BaseAllResource;
use App\Http\Resources\VmContractResource;
use App\Http\Resources\TestResource;
use App\Http\Resources\AddChildrenGroupResource;
use App\Http\Resources\GetUserInGroupResource;
use App\Http\Resources\HallResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\UsersFilter;
use App\Base;
use App\Programm;
use App\Branch;
use App\User;
use App\Role;
use App\Journal;
use App\Log;
use App\Comments;
use App\Hall;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;


class BaseController extends Controller
{


    public function prodaction(Request $request)
    {
        return "OK";
        $hall = Hall::find($request->hall_id)->load(['schedule_hall' => function ($query) use ($request){
            $query->with('group')->where('day', $request->day);
        }]);

         return new HallResource($hall);
    }


    public function showHProgramms(Request $request)
    {
        $programm = Programm::where('branch_id', $request->branch_id)->get();

         return $programm;
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

        $base = Base::where('group_id', $request->group_id)->get();

        if ($base->count() > 0) {
           return GetUserInGroupResource::collection($base);
        }else{
            return 'error';
        }

    }


    public function workout(Request $request){

        // Если на эту дату тренировка уже проставлена то нужно решить что дальше делать 
        $base = Base::find($request->base_id);

        // Выбираем только активные контракты и с типом основной контракт
        $contracts = $base->contracts->where('end_actually', '>', Carbon::today()->toDateString())->flatten()->where('contract_type', 'main');
        
        if ($contracts->count() == 1) {

            $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->where('type', 1)->get();

            // Если уже стоит этот статус то выдаем ошибку
            if (!$journal->isEmpty()) {
                return [
                    'response'  => "Уже стоит тренировка, выберите другой статус",
                ];
            }

            // Проверяем стоит ли сейчас пропущенная тренировка на текущей ячейки 
            $journal = Journal::where('base_id', $request->base_id)->where('day', $request->day)->where('type', 3)->get();

            // Если записи нет и количество тренировок в контракте больше нуля то списываем одну тренировку
            if ($journal->isEmpty() && $contracts[0]->classes_total > 0) {
                $base->contracts()->where('contract_type', 'main')->decrement('classes_total');
            }else{
                return [
                    'response'  => "У клиента закончились заморозки",
                ];
            }

            // Если есть запись то обнавляем иконку и данные, если нет то создаем новую
            $journal = Journal::updateOrCreate(
              ['day' => $request->day],
              // ['day' => $request->day, 'day' => $request->day ],
              // Сюда добавить не только выборку по дням, но и месяца тоже учитывать
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
              ['day' => $request->day],
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
            $comment = Comments::create([
                'base_id'   => $request->base_id,
                'user_id'   => Auth::user()->id,
                'comment'   => $request->comment,
            ]);

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
                      ['day' => $request->day],
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
            $comment = Comments::create([
                'base_id'   => $request->base_id,
                'user_id'   => Auth::user()->id,
                'comment'   => $request->comment,
            ]);
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

        $base = Base::create($request->all());
        
        Log::create(array(
             'user_id' => Auth::id(),
             'channel' => '2', 
             'level_name' => 'success', 
             'message' => 'добавил клиента '.$base->id)
        );
        
        return $base->id;
    }

    public function getInfo(Request $request){

        $base = Base::find($request->id);
        
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

        Log::create(array(
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

}
