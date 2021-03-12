<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programm;
use App\Loger;
use Illuminate\Support\Facades\Auth;

class ProgrammController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $programm = Programm::create($request->all());

        loger(3, null,null,null,'Добавил программу '.$programm->name);

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programm $programm)
    {
        $field_name = $request['field_name'];
        $programm->$field_name = $request['field_value'];
        $programm->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Programm $programm)
    {
        $programm->delete();

        loger(3, null,null,null,'Удалил программу '.$programm->name);

//        return response(null, Response::HTTP_NO_CONTENT);
    }

    //    Обновляем тип программы родителя
    public function updateTypeProgramm(Request $request){

        Programm::where('id', $request->id)->update(['type' => $request->type]);

        return [
            'success' => 'ok'
        ];
    }
}
