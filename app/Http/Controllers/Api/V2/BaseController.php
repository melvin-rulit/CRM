<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\BaseCurrentUser;
use App\Http\Resources\VmContractResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Base;

class BaseController extends Controller
{

	public function index(){

		return new BaseCurrentUser(Base::all());
	}

    public function getInfo(Request $request){

        $base = Base::find($request['id']);
        return new ArticleResource($base);
    }

   	public function getVmContract(Request $request){

        $base = Base::find($request['id']);
        return new VmContractResource($base);
    }

}
