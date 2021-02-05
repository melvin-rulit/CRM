<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Branch;
use App\Http\Resources\GenerlResource;
use App\Http\Resources\GetUsersWarehouse;
use App\Http\Resources\WarehousePositionResource;
use App\Region;
use App\Warehouse;
use App\WarehousePosition;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouse = Warehouse::all();

        return $warehouse;
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
        Warehouse::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehous = Warehouse::find($id);

        return new GenerlResource($warehous);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id)->positions->count();


        if ($warehouse == 0){
            Warehouse::find($id)->delete();
        }else{
            return [
                'response'  => "error",
            ];
        }
    }


    public function getBranches(Request $request)
    {
        $branches = Branch::where('region_id', $request->id)->get();

        return $branches;
    }

    public function getRegions()
    {
        $regions = Region::all();

        return $regions;
    }

    public function getUsers(Request $request)
    {
        $users = Branch::find($request->id);

        return GetUsersWarehouse::collection($users->users);

    }

    public function showWarehousePosition(Request $request)
    {
        $warehouse_position = WarehousePosition::where('warehouse_id', $request->id)->get();

        return WarehousePositionResource::collection($warehouse_position);

    }
}
