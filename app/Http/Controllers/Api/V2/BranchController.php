<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BranchResource;
use Symfony\Component\HttpFoundation\Response;
use App\Branch;
use App\Loger;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
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
        $branch = Branch::create($request->all());

        Loger::create(array(
             'user_id' => Auth::id(),
             'channel' => '3',
             'level_name' => 'success',
             'message' => 'добавил филиал '.$branch->id)
        );

        return (new BranchResource($branch))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }


//    public function show(Branch $branch)
//    {
//
//        return (new BranchResource($branch->load(['products.pays','programms','dopproducts', 'halls'])))
//                ->response()
//                ->setStatusCode(Response::HTTP_CREATED);
//    }



    public function show(Branch $branch)
    {
        $branch->load([
            'products' => function($query){
                $query->orderBy('date_end');
            },
            'products.pays',
            'programms',
            'dopproducts',
            'halls'
        ]);
    return (new BranchResource($branch))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
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

    public function update(Request $request, Branch $branch)
    {
        $field_name = $request['field_name'];
        $branch->$field_name = $request['field_value'];
        $branch->save();

        Loger::create(array(
             'user_id' => Auth::id(),
             'channel' => '3',
             'level_name' => 'success',
             'message' => 'изменил поле '.$request['field_name'].' филиала '.$branch->id.' на '.$request['field_value'])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        Loger::create(array(
             'user_id' => Auth::id(),
             'channel' => '3',
             'level_name' => 'success',
             'message' => 'удалил филиал '.$branch->id)
        );
    }
}
