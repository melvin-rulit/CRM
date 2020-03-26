<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Permission;
use App\RoleAccess;

class RoleAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleAccess = Role::all();
        return view('admin.roleAccess.index', compact('roleAccess'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = Role::all()->pluck('title', 'id');
        $role = Role::find($id);

        return view('admin.roleAccess.edit', compact('permissions', 'role'));
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
        RoleAccess::where('role_id', '=', $request->role_id)->delete();
        foreach ($request->input('permissions', []) as $key => $value) {
            $calendar = new RoleAccess;
            $calendar->role_id = $request->role_id;
            $calendar->role_access = substr($value, 0, strpos($value, "-"));
            $calendar->save();
        }
        return redirect()->route('admin.roleaccess.index');

        //RoleAccess::where('role_id', '=', $request->role_id)->delete();
        //RoleAccess::delete($request->input('permissions', []));

        //return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    static function getName($id){
        $name = Role::find($id);
        return $name->title;
    }
}
