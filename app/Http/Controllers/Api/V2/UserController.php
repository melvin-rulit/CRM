<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Branch;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersAllResource;
use App\Http\Resources\GetUser;
use App\Http\Resources\GetBranchAndRolesUser;
use App\Http\Resources\UserHistory;
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
        //Отсортировать коллекцию на дубли
        return UsersAllResource::collection($collection->unique('id'));
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

    public function saveBranches(Request $request){

        $user = User::find($request->user_id);

        $user->branches()->sync($request->branches);

    }

    public function saveRoles(Request $request){

        $user = User::find($request->user_id);

        $user->roles()->sync($request->roles);
    }
}
