<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\BranchResource;
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

        Loger::create(array(
             'user_id' => Auth::id(),
             'channel' => '3',
             'level_name' => 'success',
             'message' => 'добавил продукт '.$product->id)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return (new BranchResource($product->load(['pays'])))
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
        $field_name = $request['field_name'];
        $product->$field_name = $request['field_value'];
        $product->save();
    }


    public function destroy(Product $product)
    {
        $product->delete();

        Loger::create(array(
             'user_id' => Auth::id(),
             'channel' => '3',
             'level_name' => 'success',
             'message' => 'удалил продукт '.$product->id)
        );

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
