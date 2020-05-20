<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programm;
use App\Log;
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

        Log::create(array(
             'user_id' => Auth::id(),
             'channel' => '3', 
             'level_name' => 'success', 
             'message' => 'добавил программу '.$programm->id)
        );
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

        Log::create(array(
             'user_id' => Auth::id(),
             'channel' => '3', 
             'level_name' => 'success', 
             'message' => 'удалил программу '.$programm->id)
        );

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
