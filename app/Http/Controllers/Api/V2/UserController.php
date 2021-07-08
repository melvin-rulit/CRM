<?php

namespace App\Http\Controllers\Api\V2;

use App\UserArticle;
use App\Http\Controllers\Controller;
use App\Branch;
use App\Http\Resources\KitsResource;
use App\Role;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersAllResource;
use App\Http\Resources\GetUser;
use App\Http\Resources\GetBranchAndRolesUser;
use App\Http\Resources\UserHistory;
use App\Http\Resources\GatesResource;
use App\User;
use App\Loger;


class UserController extends Controller
{

    //---------------------- Получаем информацию при открыти карточки юзера  -------------------//

    public function index()
    {
        $user = User::find(Auth::user()->id);

        $collection = collect();

        foreach ($user->branches as $branch) {
            foreach ($branch->users as $user) {
                $collection->push($user);
            }
        }

        // Отсортировываем коллекцию на дубли и не показываем Хозяина СРМ
        $result = $collection->filter(function ($item) {
            return $item->id > 1;
        })->unique('id');


        return (UsersAllResource::collection($result))
            ->additional([
                    'can' => [
                        'user_show' => Gate::allows('user_show'),
                        'user_branch' => Gate::allows('user_branch'),
                        'user_create' => Gate::allows('user_create'),
                        'user_role' => Gate::allows('user_role'),
                        'user_edit' => Gate::allows('user_edit'),
                        'user_delete'  => Gate::allows('user_delete'),
                        'user_show_password' => Gate::allows('user_show_password'),
                    ]
                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAtributes()
    {
        $user = User::find(Auth::user()->id);

        return new GetBranchAndRolesUser($user);
    }


    public function history(Request $request)
    {
        if ($request->history_type === 'history') {

            $history = Loger::where('user_id', $request->user_id)->where('channel', '!=', 9)->get();
            return UserHistory::collection($history);

        } elseif ($request->history_type === 'career') {

//            $history = Loger::where('channel', '=', 9)->where('user_id', $request->user_id)->get();
            $history = Loger::where('channel', '=', 9)->get();
            return UserHistory::collection($history);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('role', []));
        $user->branches()->sync($request->input('branch', []));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return GetUser
     */
    public function show(User $user)
    {
        return new GetUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return string
     */
    public function update(Request $request, User $user)
    {

        $field_name = $request['field_name'];
        $user->$field_name = $request['field_value'];
        $user->save();

        return "OK";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy(User $user)
    {
        $user->delete();

        return "Сотрудник удален";
    }

    public function getUserNameFromMenu()
    {

        $user = User::find(Auth::user()->id);

        return [
            "surname" => $user->surname,
            "name" => $user->name,
            "id" => $user->id,
            "avatar" => $user->avatar,
        ];
    }

    public function getPermisions()
    {

        $user = User::find(Auth::user()->id);

        return $user->branches;
    }

    public function getAllBranches()
    {

        return Branch::all();

    }

    public function getAllRoles()
    {

        return Role::all();

    }

    //------------------------ Загрузка аватарки -------------------------------//

    public function upload(Request $request)
    {
        $path = $request['file']->store('public/avatars');
        $path = str_replace("public", "storage", $path);

        $base = User::find($request['id']);
        $base->avatar = $path;
        $base->save();

        loger(2, $base->id, null, null, 'Изменил аватар ' . $base->name);


        return $path;
    }

//-------------------------------- Добовление Филиала в карточке сотрудника ----------------//

    public function saveBranches(Request $request)
    {
        $user = User::find($request->user_id);

        $user->branches()->sync($request->branches);

        $userName = User::find(Auth::user()->id);

        loger(9, $userName->id, null,null, $userName->surname . ' ' . $userName->name. ':' . '  добавил(a)  '. '" '  .$user->name . ' "'. ' филиал  ( '  . $request->lastBranch[0]['name'] .  ' )');

    }

    //-------------------------- Добовление Должности в карточке сотрудника ----------------//

    public function saveRoles(Request $request)
    {
        $user = User::find($request->user_id);

        $user->roles()->sync($request->roles);

        $userName = User::find(Auth::user()->id);


      loger(9, $userName->id, null,null, $userName->surname . ' ' . $userName->name. ':' . '  добавил(a)  '. '" '  .$user->name . ' "'. ' должность  ( '  . $request->lastRole[0]['title'] .  ' )');

    }

    public function getUserKit(Request $request)
    {
        $kits = UserArticle::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->get();

        return KitsResource::collection($kits);
    }

    public function getFilter(Request $request)
    {
        return User::filter($request->all())->get();
    }

    public function getGates()
    {

        return [
            'journal_pk' => Gate::allows('journal_pk'),
            'journal_not_visit' => Gate::allows('journal_not_visit'),
            'journal_visit' => Gate::allows('journal_visit'),
            'journal_chart_add' => Gate::allows('journal_chart_add'),
            'journal_chart_delete' => Gate::allows('journal_chart_delete'),
            'journal_transfer_group' => Gate::allows('journal_transfer_group'),
        ];
    }
}
