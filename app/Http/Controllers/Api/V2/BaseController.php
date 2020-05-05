<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\BranchesResource;
use App\Http\Resources\UsersResource;
use App\Http\Resources\BaseCurrentUser;
use App\Http\Resources\VmContractResource;
use App\Http\Resources\TestResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\UsersFilter;
use App\Base;
use App\Branch;
use App\User;

class BaseController extends Controller
{

    public function test(Request $request){

        $base = Base::find($request['id']);

        return new TestResource($base->load(['base_branch']));
    }

    // Получаем все пользователей из базы и отдаем его ресурсу 
	public function index(){

		return new BaseCurrentUser(Base::all());
	}
    // Создаем нового пользователя в базе
	public function addNewUser(Request $request){

        $base = Base::create($request->all());
        return $base->id;
    }
    // Получаем пользователя по ID и отдаем его ресурсу
    public function getInfo(Request $request){

        $base = Base::find($request->id);
        return new ArticleResource($base);
    }
    // Получаем пользователя по ID и отдаем его ресурсу контракта
   	public function getVmContract(Request $request){

        $base = Base::find($request->id);
        return new VmContractResource($base->load(['base_branch']));
    }
    // Получаем список доступных филиалов и отдаем его ресурсу
    public function getBranches(){

        return new BranchesResource(Branch::all());
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

        return $path;
    }

    public function filter(Request $request, UsersFilter $filters)
    {

        $users = Base::filter($filters)->get();

        if ($request->expectsJson()) {
            return response()->json($users->toArray());
        }

        return view('pages.product', compact('users'));
    }

}
