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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                    'user_show'             => Gate::allows('user_show'),
                    'user_branch'           => Gate::allows('user_branch'),
                    'user_create'           => Gate::allows('user_create'),
                    'user_role'             => Gate::allows('user_role'),
                    'user_edit'             => Gate::allows('user_edit'),
                    'user_show_password'    => Gate::allows('user_show_password'),
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $history = Loger::where('user_id', $request->user_id)->get();

        return UserHistory::collection($history);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new GetUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

    public function getUserNameFromMenu(){

        $user = User::find(Auth::user()->id);

        return [
            "surname" => $user->surname,
            "name" => $user->name,
        ];
    }

    public function getPermisions(){

        $user = User::find(Auth::user()->id);

        return $user->branches;
    }

    public function getAllBranches(){

        return Branch::all();

    }

    public function getAllRoles(){

        return Role::all();

    }

    public function saveBranches(Request $request)
    {
        $user = User::find($request->user_id);

        $user->branches()->sync($request->branches);

    }

    public function saveRoles(Request $request)
    {
        $user = User::find($request->user_id);

        $user->roles()->sync($request->roles);
    }

    public function getUserKit(Request $request)
    {
        $kits = UserArticle::where('user_id', $request->user_id)->orderBy('created_at','desc')->get();

        return KitsResource::collection($kits);
    }

    public function getFilter(Request $request)
    {
        return User::filter($request->all())->get();
    }


    public function getGates(){

        return [
                'journal_pk'                => Gate::allows('journal_pk'),
                'journal_not_visit'         => Gate::allows('journal_not_visit'),
                'journal_visit'             => Gate::allows('journal_visit'),
                'journal_chart_add'         => Gate::allows('journal_chart_add'),
                'journal_chart_delete'      => Gate::allows('journal_chart_delete'),
                'journal_transfer_group'    => Gate::allows('journal_transfer_group'),
        ];
    }
}
