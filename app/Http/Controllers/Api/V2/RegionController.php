<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\RegionResource;
use Symfony\Component\HttpFoundation\Response;
use App\Region;
use Gate;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return (RegionResource::collection(Region::with(['branches'])->get()))
            ->additional([
                    'can' => [
                        'region_create'     => Gate::allows('region_create'),
                        'region_edit'       => Gate::allows('region_edit'),
                        'region_delete'     => Gate::allows('region_delete'),
                        'branch_create'     => Gate::allows('branch_create'),
                        'branch_edit'       => Gate::allows('branch_edit'),
                        'branch_hall'       => Gate::allows('branch_hall'),
                        'branch_delete'     => Gate::allows('branch_delete'),
                        'add_conditions'    => Gate::allows('add_conditions'),
                        'edit_conditions'   => Gate::allows('edit_conditions'),
                        'show_conditions'   => Gate::allows('show_conditions'),
                        'add_products'      => Gate::allows('add_products'),
                        'edit_products'     => Gate::allows('edit_products'),
                        'show_products'     => Gate::allows('show_products'),
                        'add_dop_products'    => Gate::allows('add_dop_products'),
                        'edit_dop_products'   => Gate::allows('edit_dop_products'),
                        'show_dop_products'   => Gate::allows('show_dop_products'),
                    ]
                ]
            );
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
        $region = Region::create($request->all());

        return (new RegionResource($region))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
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
        //
    }
}
