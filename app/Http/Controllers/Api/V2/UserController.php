<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersAllResource;
use App\Http\Resources\GetUser;
use App\Http\Resources\GetBranchAndRolesUser;
use App\User;


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

        return UsersAllResource::collection($collection->all());
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input('role', []));
        $user = User::create($request->all());
        $user->roles()->sync($request->input('role', []));
        // $user->branches()->sync($request->input('branch', ['id']));

        // По возможности изменить приходящий массив и сделать запись ролей и филиалом по нормальному
        // $user->roles()->sync($request->input('roles', ['id']));
        // $user->branches()->sync($request->input('branches', []));

        // foreach ($request->branch as $value) {
        //     $role = new Contract_pay;
        //     $contract_pays->contract_id = $contract->id;
        //     $contract_pays->pay = $value['pay'];
        //     $contract_pays->day = $value['day'];
        //     $contract_pays->save();
        // }
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
    public function update(Request $request, $id)
    {
        //
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
}
