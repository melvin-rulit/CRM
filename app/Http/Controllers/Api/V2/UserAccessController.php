<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAccessAllResource;
use App\Http\Resources\ShowUserAccessResource;
use App\UserAccess;
use App\User;
use Illuminate\Http\Request;

class UserAccessController extends Controller
{

    public function index()
    {
        $userAccess = User::where('id', '>', 1)->get();

        return UserAccessAllResource::collection($userAccess);
    }


    public function showUserAccess(Request $request)
    {
        $user = User::find($request->id);

        return new ShowUserAccessResource($user);
    }

    public function saveUserAccess(Request $request)
    {
        $user = User::find($request->user_id);

        $user->useraccess()->sync($request->input('useraccess', []));

    }

}
