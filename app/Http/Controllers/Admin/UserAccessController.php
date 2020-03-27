<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\UserAccess;

class UserAccessController extends Controller
{
    public function index(){

    	$users = User::where('id', '>', 1)->get();
    	return view('admin.useraccess.index', compact('users'));
    }


    public function edit($id)
    {

        $roles = Role::all()->pluck('title', 'id');
        $users = User::find($id);
        return view('admin.useraccess.edit', compact('roles', 'users'));
    }


    public function update(Request $request, $id)
    {

        UserAccess::where('user_id', '=', $request->user_id)->delete();

        foreach ($request->input('roles', []) as $key => $value) {
            $useraccess = new UserAccess;
            $useraccess->user_id = $request->user_id;
            $useraccess->role_id = $value;
            $useraccess->save();
        }
        return redirect()->route('admin.useraccess.index');
    }
}
