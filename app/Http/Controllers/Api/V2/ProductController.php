<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\KassaOperationType;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\BranchResource;
use App\Http\Resources\PaysInDogovorResource;
use Illuminate\Http\Request;
use App\Product;
use App\User;
use DB;
use App\Loger;
use Illuminate\Support\Facades\Auth;
use App\Filters\UsersFilter;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UsersFilter $filters)
    {

        $users = DB::table('users')->where('name', 'like', 1)->get();
        // dd($users);
            // $users = User::filter($filters)->get();

            // return $users;

        $users = (new UsersFilter($users))->apply()->get();

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

        $product = Product::create($request->all());

        KassaOperationType::create([
            'name'          => $request->name,
            'branch_id'     => $request->branch_id,
            'coming'        => true
        ]);

        loger(3, null,'Добавил продукт '.$product->name);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

//        dd($product);

        return (new PaysInDogovorResource($product->load(['pays'])))
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

    public function update(Request $request, Product $product)
    {
        if ($request['field_name'] == 'date_end'){

            $correctDate = Carbon::createFromDate($request['field_value'])->format('Y.m.d');
        }

        $field_name = $request['field_name'];
        $product->$field_name = $request['field_name'] == 'date_end' ? $correctDate : $request['field_value'];
        $product->save();
    }


    public function destroy(Product $product)
    {
        $product->delete();

        loger(3, null,'Удалил продукт '.$product->name);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
