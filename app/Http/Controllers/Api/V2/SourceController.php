<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\SourceResource;
use App\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index(){

        return SourceResource::collection(Source::all());
    }

    public function store(Request $request)
    {
        Source::create($request->all());
    }

    public function getSourceInGroup(Request $request)
    {

        $source = Source::where('group_id', $request['group_id'])->get();

        return SourceResource::collection($source);
    }

    public function update(Request $request, $id)
    {
        Source::where('id', $id)->update(
            [
                'name'      => $request->name,
                'group_id'     => $request->group_id,
                'coment'    => $request->coment,
            ]
        );
    }
}
