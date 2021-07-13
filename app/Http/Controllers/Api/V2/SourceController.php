<?php

namespace App\Http\Controllers\Api\V2;

use App\Base;
use App\Branch;
use App\Http\Controllers\Controller;
use App\Http\Resources\SourceResource;
use App\Source;
use Illuminate\Http\Request;
use Gate;

class SourceController extends Controller
{
    public function index(){

        return (SourceResource::collection(Source::all()))
            ->additional([
                    'can' => [
                        'source_create'       => Gate::allows('source_create'),
                        'source_edit'         => Gate::allows('source_edit'),
                    ]
                ]
            );
    }

    public function store(Request $request)
    {
        Source::create($request->all());
        return "Источник добавлен";
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
                'branch_id'     => $request->branch_id,
                'coment'    => $request->coment,
            ]
        );
    }

    //----------------------- Получаем отфильтрованные данные ----------------------//

    public function sourceBranch(Request $request){

        return (SourceResource::collection(Source::where('branch_id', $request['id'])->get()))
            ->additional([
                    'can' => [
                        'source_create'       => Gate::allows('source_create'),
                        'source_edit'         => Gate::allows('source_edit'),
                    ]
                ]
            );

    }

    //--------------------------- Удаление Источника с таблицы /sources -----------------------//

    public function destroy($id)
    {
        Source::where('id', $id)->delete();

        return "Источник удален из Базы данных";

    }

}
