<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\SourceGroup;
use App\Http\Resources\SourceGroupsResource;
use Illuminate\Http\Request;

class SourceGroupController extends Controller
{
    public function index(){

        return SourceGroupsResource::collection(SourceGroup::all());
    }

    public function store(Request $request)
    {
        SourceGroup::create($request->all());
    }

//    public function getGroupInSource(Request $request){
//
//        $group_in_ksource = SourceGroup::where('g_id', $request->branch_id)->get();
//
//        return GroupInKassaResource::collection($group_in_kassa);
//    }
}
